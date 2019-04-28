<?php

use buttflattery\formwizard\FormWizard;

echo FormWizard::widget([
     'formOptions'=>[
        'id'=>'form_ajax',        
        //'enableClientValidation'=>false,
        //'enableAjaxValidation'=>true,
        
    ],
    'theme' => FormWizard::THEME_ARROWS, 
    'steps'=>[
//        [
//            'model'=>$companyModel,
//            'title'=>'Company Detail',
//            'description'=>'Add your shoots',
//            'formInfoText'=>'',
//            'fieldConfig' => [
//                    'Company_Name' => [
//                        'containerOptions' => [
//                            'class' => 'col-md-6'
//                        ],
//                    ],
//                    'Address' => [
//                        'containerOptions' => [
//                            'class' => 'col-md-6'
//                        ],
//                    ],
//             ],
//        ],
        [
            'type' => FormWizard::STEP_TYPE_TABULAR,
            'model'=> [$contactModel],
            'title'=>'Contact Details',
            'description'=>'Add your shoots',
            'formInfoText'=>'',
            'fieldConfig' => [
//            'only'=>['Contact_Name','Phone'],
                        'Contact_Name' => [
                        'containerOptions' => [
                            'class' => 'col-md-6',                            
                         ]
                        ], 
                       'Phone' => [
                        'containerOptions' => [
                            'class' => 'col-md-6',                            
                         ]
                        ],
                        'Company_Id' => [
                        'options' => [
                            'type'=>'text',                                                      
                        ],
                        'template' => '<div class="col-md-6"><label class="control-label">{label}</label>{input}</div>',      
                        ],
                
//                'Company_Id' => [
//                            'options' => [
//                                'type' => 'dropdown',
//                                'itemsList' => [1 => 'Kems', 2 => 'Zajil'], //the list can be from the database
//                                'prompt' => 'Please select a value',
//                            ]
//                ],
                
            ]
        ],
    ]
]);

