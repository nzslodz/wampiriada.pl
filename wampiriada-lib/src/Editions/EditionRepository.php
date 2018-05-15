<?php namespace NZS\Wampiriada\Editions;

use NZS\Core\Exceptions\ObjectDoesNotExist;
use NZS\Core\Redirects\DatabaseRedirectRepository;
use NZS\Core\Redirects\CompositeRedirectRepository;
use NZS\Wampiriada\Editions\EmptyConfiguration;
use NZS\Wampiriada\Redirects\WampiriadaRedirectRepository;
use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\ActionData;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\School;
use Carbon\Carbon;
use DB;

// XXX should it be wise to drop caching and ObjectDoesNotExist?
class EditionRepository {
    protected
        $edition = null,
        $results,
        $actions,
        $data,
        $future_actions,
        $redirects = array();

    public function __construct(Edition $edition) {
        $this->edition = $edition;
    }

    // static constructors
    public static function current() {
        $number = Option::get('wampiriada.edition', 28);

        return static::fromNumber($number);
    }

    public static function fromNumber($number) {
        $edition = Edition::whereNumber($number)->first();

        if(!$edition) {
            throw new ObjectDoesNotExist("Edition does not exist");
        }

        return new static($edition);
    }

    public static function fromId($id) {
        $edition = Edition::find($id);

        if(!$edition) {
            throw new ObjectDoesNotExist("Edition does not exist");
        }

        return new static($edition);
    }

    public static function fromPreviousYear(EditionRepository $repository) {
        return static::fromNumber($repository->getEditionNumber() - 2);
    }

    // edition getters
    public function getEdition() {
        return $this->edition;
    }

    public function getEditionNumber() {
        return $this->edition->number;
    }

    public function getEditionType() {
        return $this->edition->number % 2 + 1;
    }

    public function getEditionYear() {
        return (int) ($this->edition->number / 2) + 2002;
    }

    // dependent model getters
    public function getResults() {
        if($this->results) {
            return $this->results;
        }

        $this->results = $this->internalGetResults();

        if(!$this->results) {
            throw new ObjectDoesNotExist("There are no results for edition {$this->getEditionNumber()}.");
        }

        return $this->results;
    }

    public function getResultsForSchool(School $school) {
        return $this->internalGetResults($school);
    }

    protected function internalGetResults(School $school = null) {
        return ActionData::whereHas('action_day', function($q) use($school) {
            $q->whereEditionId($this->edition->id);

            if($school) {
                $q->whereHas('place', function($q) use($school) {
                    $q->whereSchoolId($school->id);
                });
            }
        })->orderBy('id')->get();
    }

    public function getData() {
        if($this->data) {
            return $this->data;
        }

        $this->data = EditionData::find($this->edition->id);

        if(!$this->data) {
            throw new ObjectDoesNotExist("There is no data for edition {$this->getEditionNumber()}.");
        }

        return $this->data;
    }

    public function getActions() {
        if($this->actions) {
            return $this->actions;
        }

        $this->actions = ActionDay::with(['place.school'])
            ->whereEditionId($this->edition->id)
            ->whereHidden(false)
            ->orderBy('created_at')
            ->get();

        if($this->actions->isEmpty()) {
            throw new ObjectDoesNotExist("There are no actions defined for edition {$this->getEditionNumber()}.");
        }

        return $this->actions;
    }

    public function getFutureActions($include_today=false) {
        if($this->future_actions) {
            return $this->actions;
        }

        $this->future_actions = ActionDay::with(['place.school'])
            ->whereEditionId($this->edition->id)
            ->whereHidden(false)
            ->where(function($q) use($include_today) {
                $q->where('created_at', '>', Carbon::now());

                if($include_today) {
                    $q->orWhere(function($query) {
                        $query->where(DB::raw('DATE(created_at)'), '=', DB::raw('CURRENT_DATE()'))
                            ->where('end', '>',  DB::raw('ADDTIME(CURRENT_TIME(), "01:00")'));
                    });
                }
            })
            ->orderBy('created_at')
            ->get();

        if($this->future_actions->isEmpty()) {
            throw new ObjectDoesNotExist("There are no actions defined for edition {$this->getEditionNumber()}.");
        }

        return $this->future_actions;
    }

    public function getGalleryActions() {
        return $this->getActions()->filter(function($item) {
            return (bool) $item->gallery_link && (bool) $item->gallery_image;
        });
    }

    public function getConfiguration() {
        $configuration = $this->getEdition()->configuration;

        if(!$configuration) {
            return new EmptyConfiguration;
        }

        return $configuration;
    }

    public function getOverall() {
        return $this->getResults()->sum('overall');
    }

    public function safeGetOverall() {
        try {
            return $this->getOverall();
        } catch(ObjectDoesNotExist $e) {
            return 0;
        }
    }

    public function getOverallDifference(EditionRepository $repository) {
        return $this->getOverall() - $repository->getOverall();
    }

    // Redirects
    public function getRedirectAsTag($name, $contents, array $attrs=array()) {
        return $this->getRedirect($name)->asTag($contents, $attrs);
    }

    public function getRedirectRepository() {
        $database_repository = new DatabaseRedirectRepository;
        $wampiriada_repository = new WampiriadaRedirectRepository($this);

        return new CompositeRedirectRepository([$wampiriada_repository, $database_repository]);
    }

    public function getRedirect($name) {
        return $this->getRedirectRepository()->getRedirect($name);
    }

    public function registerRedirect($key, $url, $edition_specific=true) {
        $wampiriada_repository = new WampiriadaRedirectRepository($this);

        return $wampiriada_repository->registerRedirect($key, $url);
    }
}
