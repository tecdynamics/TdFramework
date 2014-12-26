<?php
header('utf-8');
require './db.php';


//$db= new db();

class test extends db{
public function test(){
    parent::__construct();
$ddd=$this->orm->hd_message[10];


$ss=$this->connection->query("Select * from hd_message where id=10");
for ($i=0; $i <10; $i++) {
    echo $this->orm->hd_message()->insert(array("ticket_id"=>(65+$i), "user_id" => 12, "description" => "Replacement cartridge has been ordered.  It will day approximately 3 days to be delivereddfhgdfhdfhgdfghdfdfdfdfhdfgh",
 )) . "\n";
}
//return $ddd;

//foreach ($ddd as $application) {

    return array($ddd["description"],$ss->fetch(PDO::FETCH_ASSOC));
//}

    /*
    foreach ($this->ds->application() as $application) {
        echo "$application[title] (" . $application->author["name"] . ")</br>";

        foreach ($application->application_tag() as $application_tag) {
        echo "\t" . $application_tag->tag["name"] . "\n";
    	}
    }*/

}

}

$s=new test();
echo '<pre>';
print_r($s->test());
?>
</pre>