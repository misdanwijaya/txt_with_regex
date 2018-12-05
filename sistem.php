<?php
    //untuk database
    include("db.php");

    //buka folder
    $dir = glob('STRUK/*.TXT');

        foreach ($dir as $key => $file) {
            //echo '<pre>';
            //echo file_get_contents($file).'<br>';

                $string = file_get_contents($file,true);
                //echo $string;
                //$string = '=a{!U3r! VANHOLLANO DUMAI! !12/5/2018 ! !07:01! !Jl. Jend. Sudirman No. 183 Dumai Hp. 08116252883 IDN ! ! ! !vbdumsdr01 ! !Novita ! !Cust. Name..: ! ! ! ! ! !---------------------------------! ! 2! !CHOCOMALTINE CRUNC! ! 23,400! ! 1! !EGG CHIC FLOSS ! ! 12,200! ! 1! !SHOPPING BAG SMALL! ! 0! ! ! ! ! !---------------------------------! !Subtotal ! ! 35,600! !Total Discount ! ! 0! !PB1 ! ! 3,560! !Total ! ! 39,160! !Cash ! ! 50,000! !Change back (Cash) ! ! 10,840! !=================================! ! PERIKSA KEMBALI! !struk belanja dan uang kembalian ! !anda. Komplain hanya bisa! !dilakukan saat transaksi di kasir! !Customer Service! !SMS: 08117541984! !PIN BB: 2B4DCF32! ! FOLLOW US! !ig : vanhollanobakery_jnpgroup ! !www.jnp-g.com! !Thank You! !r=V';

                //untuk ig
                $matches = array();

                //untuk subtotal
                $matches_2 = array();

                //tgl
                $matches_3 = array();

                //waktu
                $matches_4 = array();

                //ig
                if(preg_match("/!ig :/", $string)) {
                    //echo 'String berisi ig'; 
                    $s = preg_match('/ig : ([a-z,_]+)/', $string, $matches);
                } 

                //subtotal
                if(preg_match("/Subtotal.*!(.*\d.*\d)/", $string)) {
                    //echo 'String berisi ig'; 
                    $s = preg_match('/Subtotal.*!(.*\d.*\d)/', $string, $matches_2);
                }

                //tgl
                if(preg_match("/\d\d\/\d\/\d\d\d\d/", $string)) {
                    //echo 'String berisi ig'; 
                    $s = preg_match('/\d\d\/\d\/\d\d\d\d/', $string, $matches_3);
                }

                //jam
                if(preg_match("/\d\d\:\d\d/", $string)) {
                    //echo 'String berisi ig'; 
                    $s = preg_match('/\d\d\:\d\d/', $string, $matches_4);
                }

                //convert string to int
                //print_r($matches_2);
                $num = (int)str_replace(',', '', $matches_2[1]);

                //print subtotal
                echo "Subtotal: ";
                echo $num;
                echo nl2br("\n");

                //print pajak
                echo "Pajak: ";
                $hitung = $num *10/100;
                echo $hitung;
                echo nl2br("\n");

                //print tanggal
                echo "Tanggal: ";
                $date = str_replace('/', '-', $matches_3[0]);
                $date2 = date('Y-m-d', strtotime($date));
                echo $date2;
                echo nl2br("\n");

                //print jam
                echo "Jam: ";
                print_r($matches_4[0]);
                echo nl2br("\n");

                //print instagram
                echo "Instagram: ";
                print_r($matches[1]);
                echo nl2br("\n");


                //tampung ke array
                $data = array('subtotal' => $num, 'pajak'=> $hitung, 'tanggal_transaksi'=>$date2,'jam'=>$matches_4[0],'social_media'=>$matches[1]);
                
                //masukan ke databases
                print_r($data);
                insertArr("tes_php.tbl_transaksi", $data);
        }
?>