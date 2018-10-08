<?php

function image_captcha_validate(){
    $result = app('request')->session()->get('image_captcha_operation_result');
    $fieldName = app('request')->session()->get('image_captcha_fieldname');
    $response = (int) trim(app('Input')->get($fieldName));
    if($response == $result){
        return true;
    }
    return false;
}

function image_captcha_html(){
    $images = [
        'spiral1.jpg','spiral2.png','spiral3.png','spiral4.jpg',
        'spiral5.jpg','spiral6.jpg','spiral7.jpg','spiral8.jpg',
        'spiral9.jpg','spiral10.png','spiral11.jpg','spiral12.jpg',
    ];
    $randImageIndex = rand(0,11);
    $background = $images[$randImageIndex];

    $operation = image_captcha_generate_operation();
    app('request')->session()->put('image_captcha_operation_result', $operation['result']);

    $field = image_captcha_generate_fields();
    app('request')->session()->put('image_captcha_fieldname', $field['selected']);

    $image = new Imagick(dirname(__FILE__)."/".$background);
    $image->thumbnailImage(250, 120);
    $text = image_captcha_get_text($operation['text']);
    $image->drawImage($text);

    $blob = $image->getImageBlob();
    $html = "<p>Resolve the operation:</p>";
    $html .="<img src='data:image/jpg;base64,".base64_encode($blob)."' /><br/>".$field['html'];
    return $html;
}

function image_captcha_get_text($text){

    $im = new Imagick();
    $colors = ['red','black','green','yellow','orange','pink'];
    $gradientStart = $colors[rand(0,5)];
    $gradientEnd = $colors[rand(0,5)];

    $im->newPseudoImage(55, 70, "gradient:".$gradientStart."-".$gradientEnd);

    $draw = new ImagickDraw();
    $draw->pushPattern('gradient', 0, 0, 50, 50);
    $draw->composite(Imagick::COMPOSITE_OVER, 0, 0, 50, 50, $im);
    $draw->popPattern();
    $draw->setFillPatternURL('#gradient');
    $draw->setStrokeColor($colors[rand(0,5)]);
    $draw->setStrokeWidth(3);
    $draw->setFontSize(62);
    $fontFamilies = [
        'Times', "AvantGarde", "NewCenturySchlbk", "Palatino"
    ];
    $fontFamilyIndex = rand(0,3);
    $draw->setFontFamily($fontFamilies[$fontFamilyIndex]);
    $draw->setFontFamily("Palatino");

    $draw->setFontWeight(900);

    $draw->annotation(25, 75, $text);
    return $draw;
}

function image_captcha_generate_operation(){

    $op1 = rand(0,9);
    $op2 = rand(0,9);
    $type = rand(0,1);

    if($type==0){
        $result = $op1+$op2;
        $text = $op1." + ".$op2." =";
    }else{
        $result = $op1*$op2;
        $text = $op1." x ".$op2." =";
    }

    return [
        "result" => $result,
        "text" => $text
    ];
}

function image_captcha_generate_fields(){
    $html = "";
    $fieldName = substr(md5(time().rand(0,1000)),0,rand(16,32));

    $fields = [
        $fieldName
    ];

    for($i=0; $i<10; $i++){
        $fields[] = substr(md5($i.time().rand(0,1000)),0,rand(16,32));
    }
    for($i=0;$i<=250;$i++){
        $classes[] = "imc".md5(time().$i.rand(0,900));
    }

    shuffle($fields);
    $cssRows = [];
    $selectClass = [];
    foreach($fields as $field){
        $r1 = rand(0,249);
        $r2 = rand(0,249);
        $r3 = rand(0,249);
        $randomClass = $classes[$r1]." ".$classes[$r2]." ".$classes[$r3];
        if($field == $fieldName){
            $selectClass[] = $classes[$r1];
            $selectClass[] = $classes[$r2];
            $selectClass[] = $classes[$r3];
        }else{
            $usedClass[] = $classes[$r1];
            $usedClass[] = $classes[$r2];
            $usedClass[] = $classes[$r3];
            $rand = rand(1,4);
            if($rand==1){
                $cssRows[]= ".".$classes[$r1].".".$classes[$r2]."{display:none}";
            }
            if($rand==2){
                $cssRows[]= ".".$classes[$r3].".".$classes[$r1]."{display:none}";
            }
            if($rand==3){
                $cssRows[]= ".".$classes[$r3].".".$classes[$r2]."{display:none}";
            }
            if($rand==4){
                $cssRows[]= ".".$classes[$r2].".".$classes[$r1]."{display:none}";
            }
        }
        $html .= "<input type='text' name=".$field." class='".$randomClass." form-control' style='width:250px;margin-top:10px;' />";
    }
    $css = "<style>";
    $nonUsedClasses = array_values(array_diff($classes, $usedClass, $selectClass));
    $nonUsedSize = sizeof($nonUsedClasses)-1;
    foreach($usedClass as $index => $class){
        $cssRows[]= ".".$nonUsedClasses[rand(0,$nonUsedSize)].".".$class."{display:none}";
        $cssRows[]= ".".$nonUsedClasses[rand(0,$nonUsedSize)].".".$class."{display:block}";
        $cssRows[]= ".".$nonUsedClasses[rand(0,$nonUsedSize)].".".$class."{display:none}";
    }
    $cssRows[] = ".".$selectClass[1].".".$selectClass[2]."{display:block}";
    shuffle($cssRows);
    $css .= implode($cssRows," ");
    $css .= "</style>";

    $html .= $css;

    $field = [
        'selected' => $fieldName,
        'html'  => $html
    ];

    return $field;
}
