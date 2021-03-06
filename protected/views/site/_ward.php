<?php
/* @var $this SiteController */
/* @var $data Array */
?>

<div class="view ward">
    <h2 class="acname"><?=__('{wardname} Municipal Ward - #{wardno}',['{wardname}' => strtolower($data0[0]->city),'{wardno}' => $data->wardno])?></h2>

    <?php
    $this->widget ( 'zii.widgets.CDetailView', 
            array (
                    'data' => $data,
                    'attributes' => array (
                            array ( // related city displayed as a link
                                    'label' => __ ( 'Zone' ),
                                    'value' => function ($data)
                                    {
                                        $ward = AssemblyPolygon::model ()->findByAttributes ( 
                                                [ 
                                                        'acno' => $data->wardno,
                                                        'dt_code' => $data->dt_code,
                                                        'st_code' => $data->st_code 
                                                ] );
                                        if ($ward)
                                            return $ward->zone;
                                    } 
                            ),
                            array ( // related city displayed as a link
                                    'label' => __ ( 'Elected Councillor Name' ),
                                    'name' => 'name' 
                            ),
                            'party',
                            'phone',
                            'address',
                            [ 
                                    'type' => 'raw',
                                    'name' => 'phone',
                                    'label' => __ ( 'Phone' ),
                                    'value' => function ($data)
                                    {
                                        $rt = [ ];
                                        $tels = explode ( ',', $data->phone );
                                        foreach ( $tels as $tel )
                                        {
                                            $mats = [ ];
                                            $mats2 = [ ];
                                            
                                            if (preg_match ( '/\((?<std>0\d+)?\)[^\d]*(?<phone>\d+)/', $tel, $mats ))
                                            {
                                                $rt [] = CHtml::link ( $tel, 
                                                        'tel:+91' . intval ( trim ( $mats ['std'] ) ) .
                                                                 trim ( $mats ['phone'] ) );
                                            }
                                            else if (preg_match ( '/(?<phone>\d{5}\s?\d{5})/', $tel, $mats2 ))
                                            {
                                                $rt [] = CHtml::link ( $tel, 
                                                        'tel:+91' . trim ( str_replace ( ' ', '', $mats2 ['phone'] ) ) );
                                            }
                                            return implode ( ', ', $rt );
                                        }
                                    } 
                            ] 
                    
                    ) 
            ) );
    
    ?>

</div>