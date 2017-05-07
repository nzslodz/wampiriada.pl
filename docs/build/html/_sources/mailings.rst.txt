========
Mailingi
========

Ta strona pokazuje, w jaki sposób stworzyć mailing w aplikacji.

Tworzenie mailingu
==================

Aby móc wysłać mailing, należy wykonać kilka czynności.

1. Klasa Mailing Composer
-------------------------

Composer jest bazową klasą dla mailingów. Poniżej znajduje się przykładowa klasa composera.


.. code-block:: php

    use NZS\Core\Person;
    use NZS\Core\Mailing\BaseMailingComposer;

    class MyMailingComposer extends BaseMailingComposer {
        protected $campaign_key = 'my-mailing';
        protected $campaign_name = 'Mój mailing';
        protected $job_class = MyEmailJob::class;

        public function getSubject(Person $user) {
            return "Tytuł e-maila";
        }

        public function getView() {
            return 'emails.moj-mailing';
        }

        public function getContext(Person $user) {
            $repository = new SomethingRedirectRepository();

            return [
                'user' => $user,
                'composer' => $this,
                'repository' => $repository,
            ];
        }
    }

Każda z
