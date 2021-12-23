### HK FPS GENERATOR

```php
$obj = new EMV();
$obj->mcc = "0000";
$obj->account = "02";
$obj->fps_id = "100552215";
$obj->currency = "344";
$obj->amount = "100.02";

$gen = new Generator();
echo $gen->generate($obj);
