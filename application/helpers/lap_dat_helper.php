
\CI::load()->model(['Materials']);
$tmp 	= \CI::Materials()->getMaterials();
echo '<pre>';print_r($tmp);exit;