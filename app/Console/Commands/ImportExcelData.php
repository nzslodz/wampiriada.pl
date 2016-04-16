<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use NZS\Wampiriada\Edition;
use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\ShirtSize;
use NZS\Wampiriada\BloodType;
use NZS\Wampiriada\Profile;

use App\User;
use PHPExcel_IOFactory;


class ImportExcelData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import_excel_data {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import 27th edition data from prepared excel file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $file = $this->argument('file');


        try {
            $excel = PHPExcel_IOFactory::load($file);
        } catch(Exception $e) {
            dd($e->getMessage());
        }

        $edition_id = Edition::whereNumber(27)->first()->id;
        
        Checkin::whereEditionId($edition_id)->delete();

        $mapping = [
            200, 201, 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212
        ];

        $size_map = ShirtSize::pluck('id', 'name');
        $blood_type_map = BloodType::pluck('id', 'name');

        for($i = 0; $i < 13; $i++) {
            $sheet = $excel->getSheet($i);

            $action_day = ActionDay::whereId($mapping[$i])->first();

            foreach($sheet->getRowIterator() as $row) {
                $continue = false;
                
                $checkin = new Checkin;
                $first_name = null;
                $last_name = null;
                $email = null;

                foreach($row->getCellIterator() as $index => $cell) {
                    $value = $cell->getValue();
                    
                    switch($index) {
                        case "A":
                            if($value == 'Lp.') {
                                $continue = true;
                            }

                            break;
                        
                        case "B":
                            $first_name = $value;
                            break;
                        
                        case "C":
                            $last_name = $value;
                            break;
                        
                        case "D":
                            $email = $value;
                            break;
                        
                        case "E":
                            if($value == '') {
                                $checkin->blood_type_id = $blood_type_map['Nie wiem'];
                            } else {
                                $checkin->blood_type_id = $blood_type_map[str_replace(' Rh', '', $value)];
                            }

                            break;

                        case "F":
                            if($value == '') {
                                break;
                            }
                            
                            if($value == '2XL') {
                                $value = 'XXL';
                            }

                            $checkin->size_id = $size_map[$value];

                            break;

                    }
                    
                    if($continue) {
                        break;
                    }

                    if($index == "F") {
                        break;
                    }
                }

                if($continue) {
                    continue;
                }

                if(!$email) {
                    continue;
                }

                $this->info("saving $email...");

                $user = User::firstOrNew(['email' => $email]);
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->username = $email;
                $user->save();

                $profile = Profile::firstOrNew(['id' => $user->id]);
                $profile->current_name = $user->getFullName();
                $profile->default_size_id = $checkin->size_id;
                $profile->blood_type_id = $checkin->blood_type_id;
                $profile->save();

                $checkin->user_id = $user->id;
                $checkin->name = $user->getFullName();
                $checkin->edition_id = $edition_id;
                $checkin->created_at = $action_day->created_at;
                $checkin->updated_at = $action_day->updated_at;
                $checkin->action_day_id = $action_day->id;
                $checkin->save();
            }
        }
    }
}
