<?php

namespace App\Models;

use App\Models\ItemTest;
use App\Models\Item;
use App\Models\DataTester;


class Apriori  
{
       private $data;
        private $use_data;
        private $use_key;
        const MIN_SUPPORT = 0.2;
        const MIN_CONFIDENCE = 0.3;

        public function __construct($data = null,$use_data = null, $use_key){

            $this->data = $data;            
            $this->use_data = $use_data; 
            $this->use_key = $use_key;           
        }

        
        // normalization of data ==================================================================================
        private function data_normalization($use_data = null){
            $result = [];
            if($use_data == null){
                $use_data = $this->data;
            }

            if($use_data && count($use_data) > 0){
                foreach ($use_data as $key) {
                    array_push($result,$key['item']);
                }
            }

            return $result;
        }

        // end normalization of data =================================================================================

        // searching frequency ======================================================================================= 
        private function frequency(){
            $result = [];
            $temp = [];
            $processed_data = $this->data_normalization();
            
            if($processed_data){
                $count = count($this->data);
                for ($i=0; $i < count($processed_data) ; $i++) { 
                    $row = $processed_data[$i];
                    for ($j=0; $j < count($row) ; $j++) { 
                        if (array_key_exists($row[$j],$temp)) {
                            $temp[$row[$j]] += 1;
                        }
                        else{
                            $temp[$row[$j]] = 1;
                        }
                    }
                }
    
                foreach ($temp as $key => $value) {
                    $set = [
                        'item' => $key,
                        'frequency' => $value,
                        'support' => round(($value/$count),2)
                    ];
    
                    array_push($result,$set);
                }
            }



            return $result;
        }

        



        private function frequency_combination($processed_data){
            $result = [];
            $temp_processed_data = $processed_data;
            $use_data = $this->data_normalization();

            if($processed_data && $use_data){
                $count = count($this->data);
                foreach ($processed_data as $key_x => $value) {
                    $count_data = 0;
                    $data_x = explode("|",$key_x);
                    $count_x = count($data_x); 
                
                    for ($i=0; $i < count($use_data); $i++) {
                        $data_y = $use_data[$i]; 
                        $count_y = 0;
                        for ($j=0; $j < $count_x ; $j++) { 
                            for ($l=0; $l < count($data_y); $l++) { 
                                if ($data_x[$j] == $data_y[$l]) {
                                    $count_y += 1;
                                    
                                }
                            }               
                        }
                        if ($count_y >= $count_x) {
                            $count_data +=1;
                        }
                    }
                    $temp_processed_data[$key_x] = $count_data;
                    
                }
    
                foreach ($temp_processed_data as $key => $value) {
                    $set = [
                        'item' => $key,
                        'frequency' => $value,
                        'support' => round(($value/$count),2)
                    ];
    
                    array_push($result,$set);
                }

            }
            return $result;
        }


        private function frequency_antecedent(){
            $use_data = $this->data_normalization();
            $processed_data = $this->association();

            for ($i=0; $i < count($processed_data) ; $i++) { 
            $frequency = 0;
            $antecedent_data = explode("|",$processed_data[$i]['antecedent']);
            $antecedent_count = count($antecedent_data);

            for ($j=0; $j < count($use_data) ; $j++) { 
                $use_data_row = $use_data[$j];
                $found = 0;

                for ($a=0; $a < $antecedent_count ; $a++) { 

                    for ($l=0; $l < count($use_data_row) ; $l++) {

                        if ($antecedent_data[$a] == $use_data_row[$l]) {
                            $found += 1;
                        }
                    }
                }
                if ($found >= $antecedent_count) {
                    $frequency +=1;
                }
            }
            

            $processed_data[$i]['frequency_antecedent'] = $frequency;

        }
    

        return $processed_data;


        }

        // end searching frequency ===========================================================================================================

        // selection data ===============================================================================================================
        private function selection($processed_data){
            // $processed_data = $this->frequency();
            $min = self::MIN_SUPPORT;
            $result = [];
            for ($i=0; $i < count($processed_data) ; $i++) { 
                    if($processed_data[$i]['support'] >= $min){
                        array_push($result,$processed_data[$i]);
                    }
            }

            return $result;
        }

        private function selection_confidence(){
            $result = [];
            $processed_data = $this->confidence();
            $min = self::MIN_CONFIDENCE;

            for ($i=0; $i < count($processed_data) ; $i++) { 
                if ($processed_data[$i]['confidence'] >= $min) {
            
                    array_push($result,$processed_data[$i]);
                }

            }
            return $result;
        }


        private function selection_lift_ratio(){
            $result = [];
            $processed_data = $this->lift_ratio();
            for ($i=0; $i < count($processed_data); $i++) { 
                if ($processed_data[$i]['lift_ratio'] >= 1) {
                    
                array_push($result,$processed_data[$i]);
                }
            }
            return $result;
        }


        // end selection data ==============================================================================================================
        
        // combination data =========================================================================================================================
        private function combination($processed_data,$no=1){
            $result = [];
            if(!empty($processed_data)){

                $use_data = $this->data_normalization($processed_data);
                
                
                for ($i=0; $i < count($use_data) ; $i++) {
                    $combine_data[$use_data[$i]."|"] = 0;
            
                    for ($j=$i + 1; $j < count($use_data) ; $j++) {
                        $item = $use_data[$i]."|"; 
                        $item .= $use_data[$j]."|";   
                        $combine_data[$item] = 0;
                        
                        for ($k=$j+1; $k < count($use_data); $k++) { 
                            $item.=$use_data[$k]."|";
                            $combine_data[$item] = 0;
                        }
                    }
                }
            
            
                
            
                foreach ($combine_data as $key => $value) {
                    $combine_row = explode("|",$key);
                    $combine_count = count($combine_row) - 1;
                    $combine = "";
                    if ($combine_count === $no) {
                        for ($i=0; $i < $combine_count ; $i++) { 
                            $combine .= $combine_row[$i]."|";
                            
                        }
                        $result[substr($combine,0,-1)] = 0;
                    }
                }
            }


            return $result;
        }

        // combination data =============================================================================================================

        // item set ============================================================================================================================

        private function item_set(){
            // inisialisasi variable yang digunakan
            $loop = 1; // digunakan untuk pengikat perulangan (nilai kendali looping 1 = true 0 = false)
            $iteration = 0; // nilai iterasi saat proses pencarian item set
            $count_combine = 2; // jumlah kombinasi
            $item_set = []; // data penampung list item set
            $processed_data = $this->frequency();
            $data_selection = $this->selection($processed_data);

            

                // proses pencarian item set
                while ($loop == 1) {
    
                // pembuatan kombinasi item set
                $combine = $this->combination($data_selection,$count_combine);
    
                // mencari nilai frekuensi dan support dari item set
                $frequency_combine = $this->frequency_combination($combine);
                
                // menyeleksi nilai dari support itemset
                $row_item_set = $this->selection($frequency_combine);
                
                // menyiapkan baris data item set untuk ditampung
                $set = [
                    'iteration_count' => $iteration, // nilai iterasi
                    'item_set' => $row_item_set // nilai dari item set
                ];
    
                // tampung data item set
                array_push($item_set,$set);
    
                // increment dari nilai iterasi
                $iteration++;
    
                // increment dari nilai jumlah kombinasi
                $count_combine++;
    
                // pengecekkan dari itemset yang telah diseleksi, jika kosong maka variable loop = 0 (0 = false) dan looping dihentikan
                if(empty($row_item_set)){
                    $loop = 0;
    
                    // decrement iterasi karena increment tetap dilakukan walaupun di index looping ini telah dihentikan
                    $iteration --;
                }
    
                }
            
           


            // variable penampung untuk data itemset terakhir
            $use_item_set = [];


            // pengecekkan data itemset terakhir apakah kosong atau tidak
            if(empty($item_set[$iteration]['item_set']) && !empty($item_set[$iteration - 1])){

                // jika kosong maka data yang ditampung maka data itemset yang ditampung adalah data itemset dengan iterasi 1 sebelumnya
                $use_item_set = $item_set[$iteration - 1]['item_set'];
            }
            else{

                // jika tidak kosong, maka data yang ditampung adalah data itemset dengan iterasi terakhir
                $use_item_set = $item_set[$iteration]['item_set'];
            }

            return $use_item_set;
        }

        // end item set ====================================================================================================================

        // assosiation =============================================================================================================================
        private function association(){
            $processed_data = $this->item_set();
            $array = [];
    
            foreach ($processed_data as $key_x => $value_x) {
                $row = explode("|",$value_x['item']);
                
                
                for ($x=0; $x < count($row) ; $x++) {
                    $antecedent_x = $row[$x]."|";
                    

                    for ($y=0; $y < count($row) ; $y++) { 
                        $antecedent_y = null;
                        $consequence = null;
                        
                        if($row[$y] != $row[$x]){
                            $antecedent_y = $row[$y]."|";  
                        }
                        for ($z=0; $z < count($row) ; $z++) { 
                            if ($row[$z] != $row[$y] && $row[$z] != $row[$x]) {
                                $consequence .= $row[$z]."|";
                            }
                        }
                        $antecedent = $antecedent_x.$antecedent_y;
                        
                        if($antecedent != "" && $consequence != "" && $antecedent != null && $consequence != null){
                            $set = [
                                'antecedent' => substr($antecedent, 0, -1) ,
                                'consequence' => substr($consequence, 0, -1),
                                'support_consequence' => $value_x['support'],
                                'frequency_consequence' => $value_x['frequency'] 
                            ];
                            array_push($array,$set);
                        }
                        
                    }

                    // array_push($array,$row[$x]);

                
                }
                // array_push($array,$row);

            }

            


            return $array;


        }


        // end assosiation ===================================================================================================================


        // confidence=======================================================================================================================

        private function confidence(){
            $processed_data = $this->frequency_antecedent();

            for ($i=0; $i < count($processed_data) ; $i++) { 
                $frequency_antecedent = $processed_data[$i]['frequency_antecedent'];
                $frequency_consequence = $processed_data[$i]['frequency_consequence'];
                $confidence = round(($frequency_consequence/$frequency_antecedent), 2);
                
                $processed_data[$i]['confidence'] = $confidence;
            }
            return $processed_data;
        }


        // end confidence ==================================================================================================================





        // apriori data =========================================================================================================================
        private function apriori_data(){ 
            return $this->selection_confidence();
        }



        // end apriori data ===============================================================================================================
        

        // lift ratio ======================================================================================================================
        private function lift_ratio(){
            $processed_data = $this->apriori_data();
            $count = count($this->data);
             for ($i=0; $i < count($processed_data) ; $i++) { 
                $confidence = $processed_data[$i]['confidence'];
                $confidence_antecedent = $processed_data[$i]['frequency_antecedent']/$count;
                $lift_ratio = round(($confidence/$confidence_antecedent),2);
            
                $processed_data[$i]['lift_ratio'] = $lift_ratio;
            }
            return $processed_data;
        }    

        // end lift ratio =================================================================================================================


        // lift ratio data ================================================================================================================

        private function lift_ratio_data(){
            return $this->selection_lift_ratio();
        }

        // end lift ratio data =============================================================================================================
        
        // find data =======================================================================================================================
        private function find_data($processed_data,$value){

            $result = [];
            foreach ($processed_data as $key) {
                if ($value == $key['antecedent']) {
                    $result = $key;
                    break;
                }
            }

            return $result;
        }

        private function render_frequency($processed_data){

            $result = [];
            $use_data = $this->use_data;
            if(!empty($processed_data)){
                foreach ($processed_data as $row) {
                    if ($row['item'] == "custom") {
                        $set = [
                                'item_name' => "Custom",
                                'item_image' => 'assets/images/img_situs/img_custom.jpg',
                                'item_description' => null,
                                'item_weight' => null,
                                'item_stock' => null,
                                'item_price' => null,
                                'code' => "custom",
                                'path' => base_url("home/orderCustom"),
                                'frequency' => $row['frequency'],
                                'support' => $row['support']
                            ];

                            array_push($result,$set);
                    }
                    else{
                        foreach ($use_data as $key) {
                            if ($row['item'] == $key[$this->use_key]) {
                                // $key['path'] = base_url('home/detail/'.formater_concat($key['item_name'],' ',"-"));
                                $key['frequency'] = $row['frequency'];
                                $key['support'] = $row['support'];
                                array_push($result,$key);
                            }
                        }
                    }
                }
               
            }

            return $result;
        }

        private function render_data($processed_data){
            $result = [];
            $use_data = $this->use_data;
            if(!empty($processed_data)){
                $consequence_data = explode("|",$processed_data['consequence']);
                for ($x=0; $x < count($consequence_data) ; $x++) { 
                    if ($consequence_data[$x] == "custom") {
                            $set = [
                                'item_name' => "Custom",
                                'item_image' => 'assets/images/img_situs/img_custom.jpg',
                                'item_description' => null,
                                'item_weight' => null,
                                'item_stock' => null,
                                'item_price' => null,
                                'code' => "custom",
                                'path' => base_url("home/orderCustom"),
                                 
                            ];
                            array_push($result,$set);
                    }
                    else{
                        foreach ($use_data as $key) {
                            
                            if ($consequence_data[$x] == $key[$this->use_key]) {
                                // $key['path'] = base_url('home/detail/'.formater_concat($key['item_name'],' ',"-"));
                                array_push($result,$key);
                            }
                        }
                        }

                    
                }
            }

            return $result;
        }


        // end find data ====================================================================================================================



        // action get data ==================================================================================================================
        public function frekuensi_data(){
            $processed_data = $this->frequency();
            $selection_data = $this->selection($processed_data);
            return $this->render_frequency($selection_data);
        }
        
        public function item_set_data(){
            return $this->item_set();
            
        }

        public function all_apriori_data(){
            return $this->apriori_data();
        }

        public function find_apriori_data($value){
            $processed_data = $this->apriori_data();
            $find_data = $this->find_data($processed_data,$value);
            return $this->render_data($find_data);
        }

        public function all_lift_ratio_data(){
            return $this->lift_ratio_data();
        }

        public function find_lift_ratio_data($value){
            $processed_data = $this->lift_ratio_data();

            return $this->find_data($processed_data,$value);
        }

        // end action get data ==============================================================================================================
}
