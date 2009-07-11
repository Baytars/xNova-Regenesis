<?php

if(!defined("INSIDE")){ die("attemp hacking"); }

class Baglanti
{	
	private $vt;
  	public $db;
	private $result;
	private $result2;
  
  function __construct()
  {
  	global $dbsettings, $ugamela_root_path;
	require($ugamela_root_path.'config.php');
    try
    {
		  $this->vt = @ mysqli_connect($dbsettings['server'],$dbsettings['user'],$dbsettings['pass'],$dbsettings['name']);
      if (mysqli_connect_errno())
      {
        throw new Exception ('Hata: Veritabani Baglantisi Kurulamadi');
      }
			$this->db = @ mysqli_select_db($this->vt,$dbsettings['name']);
		  if (!$this->db )
			{
			  throw new Exception ('Hata: Veritabanı Secilemedi');
			}
			@ mysqli_query($this->vt,"SET NAMES 'utf8'");
			@ mysqli_query($this->vt,"SET CHARACTER SET 'utf8'");
			@ mysqli_query($this->vt,"SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
    }
    catch (Exception $e)
    {
      die($e->getMessage());
			exit;
    }
  }

  public function tablo_kontrol($tabloadi)
  {
    $sonuc = false;
    $this->query("SHOW TABLE STATUS");
    while($tablo = $this->fetchArray())
    {
      $tablo_adi = $tablo['Name'];
      if ($tabloadi == $tablo_adi)
      {
        $sonuc = true;
      }
    }
    unset($tablo_adi,$tablo,$tabloadi);
    $this->freeResult();
    return $sonuc;
  }
	
  public function doquery($query, $table, $goster=1)
  {
  	global $dbsettings, $ugamela_root_path;
	require($ugamela_root_path.'config.php');
    try 
    {
	  $sql = str_replace("{{table}}", $dbsettings["prefix"].$table, $query);
      $this->result = @ mysqli_query($this->vt,$sql);
      if ( !$this->result )
      {
        throw new Exception ('Sorgu Hatasi : ('.mysqli_error($this->vt).')');
        exit;
      } else {
        return true;
      }
    }
    catch (Exception $e)
    {
      die($e->getMessage());
      exit;
    }
  }

  public function query2($sql2)
  {
  try
  {
    $this->result2 = @mysqli_query($this->vt,$sql2);
    if ( !$this->result2 )
    {
      throw new Exception ('Sorgu Hatasi : ('.mysqli_error($this->vt).')');
      exit;
    } else {
      return true;
    }
  }
  catch (Exception $e)
  {
      die($e->getMessage());
      exit;
    }
  }
	
	public function fetchAssoc()
	{
	  return ( @mysqli_fetch_assoc($this->result) );
	}
	
	public function fetchArray()
	{
	  return ( @mysqli_fetch_array($this->result) );
	}
	
	public function fetchObject()
	{
	  return ( @mysqli_fetch_object($this->result) );
	}
	
	public function numRows()
  {
    return ( @mysqli_num_rows($this->result) );
  }
	
	public function affectedRows()
  {
    return ( @mysqli_affected_rows($this->vt) );
  }

	public function fetchRow()
  {
    return ( @ mysqli_fetch_row($this->result) );
  }

	private $kayit_sayi = 0;
	public function kayitSay($sql)
	{
	  $this->query2($sql);
		list($this->kayit_sayi) = @ mysqli_fetch_row($this->result2);
		@ mysqli_free_result($this->result2);
		return $this->kayit_sayi;
	}
	
	public function freeResult()
	{
	  return (@mysqli_free_result($this->result));
	}
	
	public function insertId()
	{
	  return (@mysqli_insert_id($this->vt));
	}

	public function escapeString($metin)
	{
		$metin = mysqli_real_escape_string($this->vt, $metin);
		return $metin;
	}

	function __destruct()
	{
		return @ mysqli_close($this->vt);
	}
}

$vt = new Baglanti();
/*
Sample Old code;
	$query = doquery("SELECT * FROM {{table}}",'config');
	while ( $row = mysql_fetch_assoc($query) )
	{
		$game_config[$row['config_name']] = $row['config_value'];
	}
Sample New code;
	$query = $vt->doquery("SELECT * FROM {{table}}",'config');
	while ( $row = $vt->fetchArray($query) )
	{
		$game_config[$row['config_name']] = $row['config_value'];
	}
*/
?>