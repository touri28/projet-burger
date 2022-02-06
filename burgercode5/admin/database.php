<?php 

class database
{
	private static $dbhost="localhost";
    private static $dbName="burger_code";
    private static $dbuser="root";
    private static $dbuserpassword="";
	private static $connection=null;
public static function connect()
{
	try
   {
	self::$connection=new PDO("mysql:host=" . self::$dbhost .";dbname=" . self::$dbName,self::$dbuser,self::$dbuserpassword);

   }
    catch(PDOException $e)
    {
	  die($e->getmessage());
    }
	return self::$connection;
	
}
	public static function  disconnect()
	{
		self::$connection=null;
	}
}


?>
	


