<?php

function get_rasiokeuangan_byscoring($cmd){
    $form   = "<body style=\"background:#ECE5B6;\">";
    global  $_FormulaType,$_NERACAKET, $_Month, $_USER, $_UNITNAME, $_NeracaType;
    $sql    = " SELECT * FROM BUS_APPLICATION WHERE 1=1 AND APPLICATION_AONAME!='1'";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    
    $min_scoring  = get_min_scoringbyType("2");
    $min_skor     = $min_scoring;     

    $bus_formula  = get_FormulaByScoring("2");
    $lapkeu       = gen_NeracaTypeByScoring("2");
    $tahunn       = tahun();
    foreach($neraca as $tahun){
        foreach($tahun as $thn=>$vneraca){
            $year[$data[ID_BUS_APPLICATION]][$thn] = $thn;
        }
    }

    foreach($ketneraca as $ket){
        foreach($ket as $thn=>$vketneraca){
            $kt[$thn] = trim($vketneraca);
        }
    }     
    $o  = 1;
    foreach($lapkeu as $pid=>$pval){
        foreach($pval as $nid=>$nval){ 
           $o++;
        }
    }
    $o-=1;        
    
    $colspan_tahun              = count($tahunn);        
    $colspan_bus_formula        = count($bus_formula);
    
    #print_r($kt);   
    $form .= "<div id=\"tablecontent\">"; 
    $form .= "<table width=\"100%\" celspacing=\"1\" celpadding=\"10\">";
    $form .= "<tr>";
    $form .= "<td class=\"tableheader\" rowspan=\"0\" align=\"center\">No</td>";
    $form .= "<td class=\"tableheader\" rowspan=\"0\" align=\"center\">Nama Lengkap AO</td>";
    $form .= "<td class=\"tableheader\" rowspan=\"0\" align=\"center\">Cabang</td>";
    $form .= "<td class=\"tableheader\" rowspan=\"0\" align=\"center\">Nomor CIF</td>";
    $form .= "<td class=\"tableheader\" rowspan=\"0\" align=\"center\">Nama Pemohon</td>";
    $form .= "<td class=\"tableheader\" rowspan=\"0\" align=\"center\">Plafond Pembiayaan</td>";
    $form .= "<td class=\"tableheader\" rowspan=\"0\" align=\"center\">Nilai Likuidasi Agunan</td>";
    $form .= "<td class=\"tableheader\" rowspan=\"0\" align=\"center\">Colateral Coverage</td>";
    $form .= "<td class=\"tableheader\" rowspan=\"0\" align=\"center\">Collateral Primary</td>";
    $form .= "<td class=\"tableheader\" rowspan=\"0\" align=\"center\">Final Score</td>";
    $form .= "<td class=\"tableheader\" rowspan=\"0\" align=\"center\">Hasil Skoring</td>";          
    $form .= "</tr>";
    
    ##$form .= "<tr>";
    ##$form .= "<td class=\"tableheader\" colspan=\"".$colspan_bus_formula*$colspan_tahun."\" align=\"center\">Rasio Keuangan</td>"; 
    ##$form .= "<td class=\"tableheader\" colspan=\"".$o*$colspan_tahun."\" align=\"center\">Laporan Keuangan Keuangan</td>";       
    ##$form .= "</tr>";

    #$form .= "<tr>";
    #foreach($bus_formula as $id_formula=>$vbusformula){
    #    $form .= "<td class=\"tableheader\" align=\"center\" colspan=\"$colspan_tahun\">$_FormulaType[$id_formula]</td>";
    #}

    #foreach($lapkeu as $pid=>$pval){
    #   foreach($pval as $nid=>$nval){
    #       $form .= "<td class=\"tableheader\" align=\"center\" colspan=\"$colspan_tahun\">".$_NeracaType[$nid]."</td>";
    #   }
    #}         
    #$form .= "</tr>"; 
    
    ##$form .= "<tr>";
    ##foreach($tahunn as $th){
    ##    $form .= "<td class=\"tableheader\" align=\"center\" colspan=\"$colspan_bus_formula\">$th</td>";          
    ##}
    ##foreach($tahunn as $th){
    ##    $form .= "<td class=\"tableheader\" align=\"center\" colspan=\"$o\">$th</td>";          
    ##}              
    ##$form .= "</tr>"; 
    ##$form .= "<tr>";
    ##foreach($tahunn as $th){
    ##    foreach($bus_formula as $id_formula=>$vbusformula){
    ##        $form .= "<td class=\"tableheader\" align=\"center\" colspan=\"\">$_FormulaType[$id_formula]</td>";
    ##    }           
    ##}
    ##foreach($tahunn as $th){
    ##    foreach($lapkeu as $pid=>$pval){
    ##       foreach($pval as $nid=>$nval){
    ##           $form .= "<td class=\"tableheader\" align=\"center\" colspan=\"\">".$_NeracaType[$nid]."</td>";
    ##       }
    ##    }            
    ##}        
    ##$form .= "</tr>";                        
    
    #$form .= "<tr>";
    #foreach($bus_formula as $id_formula=>$vbusformula){
    #    foreach($year[$data[ID_BUS_APPLICATION]] as $yr){
    #        $form .= "<td class=\"tableheader\" align=\"right\">$yr</td>";
    #    }
    #} 
    #foreach($lapkeu as $pid=>$pval){
    #   foreach($pval as $nid=>$nval){
    #      foreach($year[$data[ID_BUS_APPLICATION]] as $yr){
    #          $form .= "<td class=\"tableheader\" align=\"right\">$yr</td>";
    #      }
    #   }
    #}              
    #$form .= "</tr>";       
    $x=1;   
    while($data=sqlsrv_mssql_fetch_array($query)){
        $app          = module_getApplication_byid($data[ID_BUS_APPLICATION]);
        $bus_formula  = get_FormulaByScoring($app[ID_SCORING_TYPE]);
        $neraca       = get_NeracaValuebyAppYear($data[ID_BUS_APPLICATION]);
        $ketneraca    = get_NeracaKetbyAppYear($data[ID_BUS_APPLICATION]);
        $primecoll    = get_primarycoll_byapp($data[ID_BUS_APPLICATION]);
        $lapkeu       = gen_NeracaTypeByScoring($app[ID_SCORING_TYPE]);
        $tahunn       = tahun();
        foreach($neraca as $tahun){
            foreach($tahun as $thn=>$vneraca){
                $year[$data[ID_BUS_APPLICATION]][$thn] = $thn;
            }
        }

        foreach($ketneraca as $ket){
            foreach($ket as $thn=>$vketneraca){
                $kt[$thn] = trim($vketneraca);
            }
        }     
        $o  = 1;
        foreach($lapkeu as $pid=>$pval){
            foreach($pval as $nid=>$nval){ 
               $o++;
            }
        }
        $o-=1;        
        
/*        $colspan_tahun              = count($tahunn);        
        $colspan_bus_formula        = count($bus_formula);
        
        #print_r($kt);   
        $form .= "<div id=\"tablecontent\">"; 
        $form .= "<table width=\"100%\" celspacing=\"1\" celpadding=\"10\">";
        $form .= "<tr>";
        $form .= "<td class=\"tableheader\" rowspan=\"4\" align=\"center\">No</td>";
        $form .= "<td class=\"tableheader\" rowspan=\"4\" align=\"center\">Nama Lengkap AO</td>";
        $form .= "<td class=\"tableheader\" rowspan=\"4\" align=\"center\">Cabang</td>";
        $form .= "<td class=\"tableheader\" rowspan=\"4\" align=\"center\">Nomor CIF</td>";
        $form .= "<td class=\"tableheader\" rowspan=\"4\" align=\"center\">Nama Pemohon</td>";
        $form .= "<td class=\"tableheader\" rowspan=\"4\" align=\"center\">Plafond Pembiayaan</td>";
        $form .= "<td class=\"tableheader\" rowspan=\"4\" align=\"center\">Nilai Likuidasi Agunan</td>";
        $form .= "<td class=\"tableheader\" rowspan=\"4\" align=\"center\">Colateral Coverage</td>";
        $form .= "<td class=\"tableheader\" rowspan=\"4\" align=\"center\">Collateral Primary</td>";         
        $form .= "</tr>";
        
        $form .= "<tr>";
        $form .= "<td class=\"tableheader\" colspan=\"".$colspan_bus_formula*$colspan_tahun."\" align=\"center\">Rasio Keuangan</td>"; 
        $form .= "<td class=\"tableheader\" colspan=\"".$o*$colspan_tahun."\" align=\"center\">Laporan Keuangan Keuangan</td>";       
        $form .= "</tr>";

        #$form .= "<tr>";
        #foreach($bus_formula as $id_formula=>$vbusformula){
        #    $form .= "<td class=\"tableheader\" align=\"center\" colspan=\"$colspan_tahun\">$_FormulaType[$id_formula]</td>";
        #}

        #foreach($lapkeu as $pid=>$pval){
        #   foreach($pval as $nid=>$nval){
        #       $form .= "<td class=\"tableheader\" align=\"center\" colspan=\"$colspan_tahun\">".$_NeracaType[$nid]."</td>";
        #   }
        #}         
        #$form .= "</tr>"; 
        
        $form .= "<tr>";
        foreach($tahunn as $th){
            $form .= "<td class=\"tableheader\" align=\"center\" colspan=\"$colspan_bus_formula\">$th</td>";          
        }
        foreach($tahunn as $th){
            $form .= "<td class=\"tableheader\" align=\"center\" colspan=\"$o\">$th</td>";          
        }              
        $form .= "</tr>"; 
        $form .= "<tr>";
        foreach($tahunn as $th){
            foreach($bus_formula as $id_formula=>$vbusformula){
                $form .= "<td class=\"tableheader\" align=\"center\" colspan=\"\">$_FormulaType[$id_formula]</td>";
            }           
        }
        foreach($tahunn as $th){
            foreach($lapkeu as $pid=>$pval){
               foreach($pval as $nid=>$nval){
                   $form .= "<td class=\"tableheader\" align=\"center\" colspan=\"\">".$_NeracaType[$nid]."</td>";
               }
            }            
        }        
        $form .= "</tr>";                        
        
        #$form .= "<tr>";
        #foreach($bus_formula as $id_formula=>$vbusformula){
        #    foreach($year[$data[ID_BUS_APPLICATION]] as $yr){
        #        $form .= "<td class=\"tableheader\" align=\"right\">$yr</td>";
        #    }
        #} 
        #foreach($lapkeu as $pid=>$pval){
        #   foreach($pval as $nid=>$nval){
        #      foreach($year[$data[ID_BUS_APPLICATION]] as $yr){
        #          $form .= "<td class=\"tableheader\" align=\"right\">$yr</td>";
        #      }
        #   }
        #}              
        #$form .= "</tr>";*/                              
        
        $form .= "<tr>";
        $form .= "<td class=\"tablecontentgrid\">".$x."</td>";
        $form .= "<td class=\"tablecontentgrid\">".$_USER[$data['APPLICATION_AONAME']]."&nbsp;</td>";
        $form .= "<td class=\"tablecontentgrid\">".$_UNITNAME[$data['APPLICATION_CABANG']]."&nbsp;</td>";
        $form .= "<td class=\"tablecontentgrid\">".$data['APPLICATION_CIFNO']."&nbsp;</td>";
        $form .= "<td class=\"tablecontentgrid\">".$data['APPLICATION_CIFNAME']."&nbsp;</td>";
        $form .= "<td class=\"tablecontentgrid\">".number_format($data['APPLICATION_PLAFOND'])."</td>";
        $form .= "<td class=\"tablecontentgrid\">".number_format($data['APPLICATION_LAGUNAN'])."</td>";
        $form .= "<td class=\"tablecontentgrid\">".number_format($data['APPLICATION_COLCOV'],0)."%</td>";
        $form .= "<td class=\"tablecontentgrid\">".$primecoll[coll_name]." ( Rp.".number_format($primecoll[coll_value])." ) "."</td>"; 
        $form .= "<td class=\"tablecontentgrid\" align=\"right\">".number_format($data['APPLICATION_FINSCORE'])."</td>";
        $form .= "<td class=\"tablecontentgrid\" align=\"left\">".($data['APPLICATION_FINSCORE']>$min_skor?"Direkomendasikan":"Tidak Direkomendasikan")."</td>";
             
        ##foreach($bus_formula as $id_formula=>$vbusformula){
        ##    foreach($vbusformula as $kfrm=>$frm){ 
        ##       foreach($year[$data[ID_BUS_APPLICATION]] as $yr){
        ##           $rumus[$id_formula][$yr]             = $frm[FORMULA];
        ##           $dt[$id_formula][$yr][$frm[ID_SORT]] = $frm[ID_NERACA];
        ##       }
        ##    }
        ##    foreach($dt[$id_formula] as $key=>$val){
        ##       foreach($val as $kval=>$vl){
        ##          $str_awal  = trim("<".$kval.">");
        ##          $neraca[$vl][$key]  = ($neraca[$vl][$key]!=""?$neraca[$vl][$key]:"0");
        ##          $rumus[$id_formula][$key]       = str_replace($str_awal,$neraca[$vl][$key],$rumus[$id_formula][$key]); 
        ##          
        ##       }
        ##    }
        ##    foreach($year[$data[ID_BUS_APPLICATION]] as $yr){
        ##        $rms[$yr]   = eval('return '.$rumus[$id_formula][$yr].';'); 
        ##        #$form .= "<td class=\"tablecontentgrid\" align=\"right\">".number_format($rms[$yr],2)."</td>";
        ##        $data_rasio[$yr][$id_formula]  =  $rms[$yr];
        ##    }
        ##}
        #print_r($data_rasio);
        ##foreach($tahunn as $th){
        ##    foreach($bus_formula as $id_formula=>$vbusformula){
        ##       $form .= "<td class=\"tablecontentgrid\" align=\"right\">".number_format($data_rasio[$th][$id_formula],2)."</td>";
        ##    }
        ##}
        
        ##foreach($lapkeu as $pid=>$pval){
        ##   foreach($pval as $nid=>$nval){
        ##      foreach($year[$data[ID_BUS_APPLICATION]] as $yr){
        ##          $data_neraca[$yr][$nid] = $neraca[$nid][$yr];
        ##          #$form .= "<td class=\"tablecontentgrid\" align=\"right\">".number_format($neraca[$nid][$yr])."</td>";
        ##      }
        ##   }
        ##}
        #print_r($data_neraca);
        ##foreach($tahunn as $th){
        ##    foreach($lapkeu as $pid=>$pval){
        ##       foreach($pval as $nid=>$nval){
        ##           $form .= "<td class=\"tablecontentgrid\" align=\"right\">".number_format($data_neraca[$th][$nid])."</td>";
        ##       }
        ##    }
        ##}                                                                                      


        $x++;
        #$out  = $form; 
        
          
        
    }
    $form .= "</table>";
    $form .= "</div>";  
    print $form."<br>"; flush();
}

function get_primarycoll_byapp($id_bus_app){
     $sql   = " SELECT BUS.*, COLL.COLL_NAME 
                FROM BUS_COLLATERAL BUS
                LEFT JOIN TYPE_COLLATERAL COLL ON BUS.ID_COLL = COLL.ID_COLL 
                WHERE BUS.ID_BUS_APPLICATION='$id_bus_app' AND BUS.STATUS<>'99' AND BUS.COLL_TYPE='0001'";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
     $data  = sqlsrv_fetch_array($query);
     
     return array("coll_name"=>$data[COLL_NAME],"coll_value"=>$data[COLL_VALUE]);
}

function tahun(){
    $tahun  = "2008";
    for($i=1;$i<=6;$i++){
        $dt[$tahun] = $tahun;
        $tahun+=1;    
    }
    return $dt;
}

?>
