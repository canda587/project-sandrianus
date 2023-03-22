<?php 


$data = [
    [
        'faktur' => 'tr0986',
        'item' => [
            'handuk',
            'sabun',
            'sampo',
        ]
    ],
    [
        'faktur' => 'tr0986',
        'item' => [
            'handuk',
            'sabun',
            'sampo',
        ]
    ],
    [
        'faktur' => 'tr0926',
            'item' => [
            'sabun',
            'sampo',
            'wipol'
        ]
    ],
    [
         'faktur' => 'tr0966',
        'item' => [
            'handuk',
            'sampo',
            'wipol'
        ]
    ],
    [
        'faktur' => 'tr0766',
        'item' => [
            'sikat',
            'handuk',
            'sampo',
            'wipol'
        ]
        ],
     [
         'faktur' => 'tr0966',
        'item' => [
            'handuk',
            'wipol'
        ]
    ],
    [
         'faktur' => 'tr0966',
        'item' => [
            'handuk',
            'wipol'
        ]
    ],
     [
        'faktur' => 'tr0766',
        'item' => [
            'sikat',
            'handuk',
            'sampo',
            'wipol'
        ]
        ],
         [
        'faktur' => 'tr0766',
        'item' => [
            'sikat',
            'handuk',
            'sampo',
            'wipol'
        ]
        ],
         [
        'faktur' => 'tr0766',
        'item' => [
            'sikat',
            'odol',
            'sampo',
            'wipol'
        ]
        ],
         [
        'faktur' => 'tr0766',
        'item' => [
            'odol',
            'handuk',
            'sampo',
            'wipol'
        ]
        ],
         [
        'faktur' => 'tr0766',
        'item' => [
            'sikat',
            'odol',
            'sampo',
            'wipol'
        ]
        ], 
];

$count = count($data); 
$min =  0.3;
$min_confidence = 0.3;




function apriori_data($use_data){
    $result = [];

    foreach ($use_data as $key) {
        array_push($result,$key['item']);
    }

    return $result;
 
}

function apriori_frekuensi($processed_data,$count){

    $result = [];
    for ($i=0; $i < count($processed_data) ; $i++) { 
        $row = $processed_data[$i];
        for ($j=0; $j < count($row) ; $j++) { 
            if (array_key_exists($row[$j],$result)) {
                $result[$row[$j]] += 1;
            }
            else{
                $result[$row[$j]] = 1;
            }
        }
    }


    return $result;

}

function apriori_support($processed_data,$count){
    $result = [];

    foreach ($processed_data as $key => $value) {
        $set = [
            'item' => $key,
            'frequency' => $value,
            'support' => round(($value/$count),2)
        ];

        array_push($result,$set);
    }

    return $result;

}

function apriori_selection($processed_data,$min){

    $result = [];
    for ($i=0; $i < count($processed_data) ; $i++) { 
            if($processed_data[$i]['support'] >= $min){
                array_push($result,$processed_data[$i]);
            }
    }

    return $result;
}

function apriori_combination($processed_data,$no){
    $result = [];
    if(!empty($processed_data)){

        $use_data = apriori_data($processed_data);
        
        
        for ($i=0; $i < count($use_data) ; $i++) {
            $combine_data[$use_data[$i]."-"] = 0;
    
            for ($j=$i + 1; $j < count($use_data) ; $j++) {
                $item = $use_data[$i]."-"; 
                $item .= $use_data[$j]."-";   
                $combine_data[$item] = 0;
                
                for ($k=$j+1; $k < count($use_data); $k++) { 
                    $item.=$use_data[$k]."-";
                    $combine_data[$item] = 0;
                }
            }
        }
    
    
        
      
        foreach ($combine_data as $key => $value) {
            $combine_row = explode("-",$key);
            $combine_count = count($combine_row) - 1;
            $combine = "";
            if ($combine_count === $no) {
                for ($i=0; $i < $combine_count ; $i++) { 
                    $combine .= $combine_row[$i]."-";
                    
                }
                $result[substr($combine,0,-1)] = 0;
            }
        }
    }


    return $result;
}

function apriori_frekuensi_many($processed_data,$use_data,$count){
     $result = [];
     $data_F = $processed_data;

     foreach ($processed_data as $key_x => $value) {
        $count_data = 0;
        $data_x = explode('-',$key_x);
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
        $data_F[$key_x] = $count_data;
        
    }

    foreach ($data_F as $key => $value) {
        $set = [
            'item' => $key,
            'frequency' => $value,
            'support' => round(($value/$count),2)
        ];

        array_push($result,$set);
    }
    return $result;
}

function apriori_associtation($processed_data){
    $array = [];
    
    foreach ($processed_data as $key_x => $value_x) {
        $row = explode('-',$value_x['item']);
        
        
        for ($x=0; $x < count($row) ; $x++) {
            $antecedent_x = $row[$x].'-';
            

            for ($y=0; $y < count($row) ; $y++) { 
                $antecedent_y = null;
                $consequence = null;
                
                if($row[$y] != $row[$x]){
                    $antecedent_y = $row[$y].'-';  
                }
                for ($z=0; $z < count($row) ; $z++) { 
                    if ($row[$z] != $row[$y] && $row[$z] != $row[$x]) {
                        $consequence .= $row[$z]."-";
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


function apriori_frequency_antecedent($processed_data,$use_data){
   
    
    for ($i=0; $i < count($processed_data) ; $i++) { 
        $frequency = 0;
        $antecedent_data = explode("-",$processed_data[$i]['antecedent']);
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


function apriori_confidence($processed_data){
    

    for ($i=0; $i < count($processed_data) ; $i++) { 
        $frequency_antecedent = $processed_data[$i]['frequency_antecedent'];
        $frequency_consequence = $processed_data[$i]['frequency_consequence'];
        $confidence = round(($frequency_consequence/$frequency_antecedent), 2);
        
        $processed_data[$i]['confidence'] = $confidence;
    }
    return $processed_data;
}


function apriori_selection_confidence($processed_data,$min){
    $result = [];
    for ($i=0; $i < count($processed_data) ; $i++) { 
        if ($processed_data[$i]['confidence'] >= $min) {
      
            array_push($result,$processed_data[$i]);
        }

    }
    return $result;
}

function lift_ratio($processed_data,$count){
    // $array = [];
    for ($i=0; $i < count($processed_data) ; $i++) { 
        $conf = $processed_data[$i]['confidence'];
        $confA = $processed_data[$i]['frequency_antecedent']/$count;
        $liftRatio = round(($conf/$confA),2);
       
        $processed_data[$i]['lift_ratio'] = $liftRatio;
    }
    return $processed_data;
}

function lift_ratio_selection($processed_data){
    $result = [];
    for ($i=0; $i < count($processed_data); $i++) { 
        if ($processed_data[$i]['lift_ratio'] >= 1) {
            
        array_push($result,$processed_data[$i]);
        }
    }
    return $result;
}

function testerLoop(){

//     $array = array(1, 2, 3, 4, 5,5,5);
//  $n = count($array);  
//    $max = $array[0]; 
//    for ($i = 1; $i < $n; $i++)  
//        if ($max < $array[$i]) 
//            $max = $array[$i]; 
//     return $max;

    $data = [
        [
            "item" => "A",
            "like" => 100
        ],
      

    ];

    $n = count($data);
    $use_data = [];
   $max = $data[0]['like']; 
   for ($i = 1; $i < $n; $i++){
       if ($max < $data[$i]['like']){
           $max = $data[$i]['like'];
           $use_data = $data[$i]; 
       } 

   }  
    return $use_data;

}

$apriori_data = apriori_data($data);
$apriori_frekuensi = apriori_frekuensi($apriori_data,$count);
$apriori_support = apriori_support($apriori_frekuensi,$count);
$apriori_selection = apriori_selection($apriori_support,$min);
$apriori_normal_data = apriori_data($apriori_selection);

$apriori_combination = apriori_combination($apriori_selection,3);
$apriori_frekuensi_second = apriori_frekuensi_many($apriori_combination,$apriori_data,$count);
$apriori_selection_second = apriori_selection($apriori_frekuensi_second,$min);

$apriori_associtation = apriori_associtation($apriori_selection_second);
$apriori_frequency_antecedent = apriori_frequency_antecedent($apriori_associtation,$apriori_data);
// $apriori_confidence = apriori_confidence($apriori_frequency_antecedent);
// $apriori_selection_confidence = apriori_selection_confidence($apriori_confidence,$min_confidence);


// implementasi

?>
@dump("implementasi =====================================")

   @php
            // inisialisasi variable yang digunakan
            $loop = 1; // digunakan untuk pengikat perulangan (nilai kendali looping 1 = true 0 = false)
            $iteration = 0; // nilai iterasi saat proses pencarian item set
            $count_combine = 2; // jumlah kombinasi
            $implement_data = []; // data penampung list item set

            // proses pencarian item set
            while ($loop == 1) {

            // pembuatan kombinasi item set
            $apriori_combination_implement = apriori_combination($apriori_selection,$count_combine);

            // mencari nilai frekuensi dan support dari item set
            $apriori_frekuensi_second_implement = apriori_frekuensi_many($apriori_combination_implement,$apriori_data,$count);
            
            // menyeleksi nilai dari support itemset
            $apriori_selection_second_implement = apriori_selection($apriori_frekuensi_second_implement,$min);
            
            // menyiapkan baris data item set untuk ditampung
            $set = [
                'iteration_count' => $iteration, // nilai iterasi
                'item_set' => $apriori_selection_second_implement // nilai dari item set
            ];

            // tampung data item set
            array_push($implement_data,$set);

            // increment dari nilai iterasi
            $iteration++;

            // increment dari nilai jumlah kombinasi
            $count_combine++;

            // pengecekkan dari itemset yang telah diseleksi, jika kosong maka variable loop = 0 (0 = false) dan looping dihentikan
            if(empty($apriori_selection_second_implement)){
                $loop = 0;

                // decrement iterasi karena increment tetap dilakukan walaupun di index looping ini telah dihentikan
                $iteration --;
            }

            }

            // variable penampung untuk data itemset terakhir
            $implement_use_data = [];

            // pengecekkan data itemset terakhir apakah kosong atau tidak
            if(empty($implement_data[$iteration]['item_set'])){

                // jika kosong maka data yang ditampung maka data itemset yang ditampung adalah data itemset dengan iterasi 1 sebelumnya
                $implement_use_data = $implement_data[$iteration - 1]['item_set'];
            }
            else{

                // jika tidak kosong, maka data yang ditampung adalah data itemset dengan iterasi terakhir
                $implement_use_data = $implement_data[$iteration]['item_set'];
            }

            // pembuatan asosiasi dari hasil akhir itemset yang didapat
            $apriori_associtation_implement = apriori_associtation($implement_use_data);

            // pencarian nilai frekuensi dari antecedent untuk digunakan pada proses selanjutnya yaitu pencarian nilai confidence
            $apriori_frequency_antecedent_implement = apriori_frequency_antecedent($apriori_associtation_implement,$apriori_data);

            // pencarian nilai confidence
            $apriori_confidence_implement = apriori_confidence($apriori_frequency_antecedent_implement);

            // proses seleksi nilai confidence
            // $apriori_selection_confidence_implement = apriori_selection_confidence($apriori_confidence_implement,$min_confidence);

            // proses lift ratio
            // $lift_ratio = lift_ratio($apriori_selection_confidence_implement,$count);

            // seleksi lift ratio
            // $lift_ratio_selection = lift_ratio_selection($lift_ratio)

   @endphp


@dump("list asosiasi data",$implement_data)
@dump("kombinasi terakhir",$iteration)


@dump("data itemset yang digunakan",$implement_use_data)

@dump("data asosiasi",$apriori_associtation_implement)

@dump("pencarian frekuensi antecedent",$apriori_frequency_antecedent_implement)

@dump("pencarian confidence",$apriori_confidence_implement)

{{-- @dump("seleksi confidence",$apriori_selection_confidence_implement) --}}


{{-- @dump("lift ratio",$lift_ratio)

@dump("seleksi lift ratio",$lift_ratio_selection) --}}

@dump("tester ============================================")
{{-- @dump("jumlah data",$count) --}}

{{-- @dump("minimal support",$min) --}}

{{-- @dump("data awal",$data)

@dump("data di olah",$apriori_data)

@dump("data frekuensi pertama",$apriori_frekuensi)

@dump("data support pertama",$apriori_support)

@dump("data seleksi pertama",$apriori_selection)

@dump("data normal",$apriori_normal_data)


@dump("data kedua",$apriori_combination)

@dump("frekuensi data kedua",$apriori_frekuensi_second)

@dump("seleksi data kedua",$apriori_selection_second)

@dump("assosiasi data kedua",$apriori_associtation)

@dump("frquency data kedua",$apriori_frequency_antecedent)

@dump("confidence data kedua",$apriori_confidence)

@dump("seleksi confidence data kedua",$apriori_selection_confidence)

@dump("tester loop",testerLoop()) --}}

@dump("tester loop",testerLoop())


