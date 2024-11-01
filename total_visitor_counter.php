<?php
class Total_visitor_counter extends WP_Widget{
    var $sessionTimeInMin = 5; // time session will live, in minutes

//    public function __construct(){
//       parent::__construct();
//   }
 
  public  function VisitorCounter(){
        $ip = $_SERVER['REMOTE_ADDR'];
        $browser = $_SERVER['HTTP_USER_AGENT'];
        //$this->cleanVisitors();
 
//        if ($this->visitorExists($ip,$browser)){
//            $this->updateVisitor($ip,$browser);
//        } else {
//            $this->addVisitor($ip,$browser);
//        } 
        $this->addVisitor($ip,$browser);
    }
 
   public function visitorExists($ip,$browser){
        global $wpdb;       
        $wpdb->get_results( "SELECT COUNT(*) FROM wp_counter_total WHERE ip = '$ip' AND browser = '$browser'" );
        $rowCount = $wpdb->num_rows;
        if ($rowCount > 0){
            return true;
        } else if ($rowCount == 0){
            return false;
        }
    }
 
//  private  function cleanVisitors(){
//        $sessionTime = 30;
//        $sql = "select * from wp_counter_total";
//        $res = mysql_query($sql);
//        while ($row = mysql_fetch_array($res)){
//            if ($row['lastvisit'] < date('Y-m-d')){
//                $dsql = "DELETE FROM wp_counter_total WHERE id = '".$row['id']."'";
//            }
//        }
//    }
 
 
  private  function updateVisitor($ip,$browser){ 
        //$sql = "update wp_counter_total set lastvisit = '" . date('Y-m-d') . "' where ip = '$ip' AND browser = '$browser'";
       // mysql_query($sql);
        global $wpdb;
        $wpdb->update( "wp_counter_total", array("lastvisit"=>date("Y-m-d H:i:s")), array("ip"=>$ip,"browser"=>$browser), $format = null, $where_format = null );
        //echo $wpdb->last_query;
        //die();
    }
 
 
  private  function addVisitor($ip,$browser){
        //$sql = "insert into wp_counter_total (ip,browser,lastvisit) values('$ip','$browser','" . date('Y-m-d') . "')";
        //mysql_query($sql);
    date_default_timezone_set("Asia/Dhaka");
    global $wpdb;
    $wpdb->insert('wp_counter_total', array(
        'ip' => $ip,
        'browser' => $browser,
        'lastvisit' => date('Y-m-d H:i:s')
    ));
    }
 
  
    
    public function onlineVisitor()
    {
        global $wpdb;
        //echo "SELECT COUNT(id) AS tid FROM wp_counter_total WHERE DATE(lastvisit) >= '".date('Y-m-d H:i:s', strtotime('-5 minutes'))."'";
        $wpdb->get_row( "SELECT COUNT(id) AS tid FROM wp_counter_total WHERE lastvisit >= '".date('Y-m-d H:i:s', strtotime('-5 minutes'))."' GROUP BY ip,browser" );
        //echo $wpdb->last_query;
        //dei();
        //$wpdb->get_results( 'SELECT COUNT(*) FROM $wpdb->rah_leads' );
        //$rowCount = $wpdb->num_rows;
        //echo $row->tid;
        echo $wpdb->num_rows;
    }
    
    public function todaysVisitor()
    {
        global $wpdb;
        //$sql = "SELECT COUNT(id) AS tid FROM wp_counter_total WHERE DATE(lastvisit) = '".date('Y-m-d')."'";
        //echo date('Y-m-d');
        //echo "<br/>";
        $row = $wpdb->get_row( "SELECT COUNT(id) AS tid FROM wp_counter_total WHERE DATE(lastvisit) = '".date('Y-m-d')."'" );
        echo $row->tid;
    }
    
    public  function getAmountVisitors(){
        global $wpdb;
        $row = $wpdb->get_row( "SELECT COUNT(id) AS tid FROM wp_counter_total" );
        echo $row->tid;
    }
}
?>