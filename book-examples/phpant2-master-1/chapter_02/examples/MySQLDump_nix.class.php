<?php
/**
 * MySQLDump_nix Class<br />
 * Backs up a database, creating a file for each day of the week,
 * using the mysqldump utility on a *nix operating system.<br />
 * Can compress backup file with gzip of bzip2<br />
 * Intended for command line execution in conjunction with
 * cron<br />
 * Requires the user executing the script has permission to execute
 * mysqldump.
 * <code>
 * $mysqlDump = new MySQLDump_nix('user', 'secret', 'world',
 *                            '/backups');
 * $mysqlDump->backup();
 * </code>
 * @access public
 * @uses MySQLDump 
 */
require_once 'AbstractMySQLDump.class.php';
class MySQLDump_nix extends MySQLDump
{
  /**
   * The backup command to execute
   * @access private
   * @var string
   */
  protected $cmd;

  /**
   * MySQLDump constructor
   * @param string dbUser (MySQL User Name)
   * @param string dbPass (MySQL User Password)
   * @param string dbName (Database to select)
   * @param string dest (Full dest. directory for backup file)
   * @param string zip (Zip type; gz - gzip [default], bz2 - bzip)
   * @access public
   */
  public function __construct($dbUser, $dbPass, $dbName, $dest,
    $zip = 'gz')
  {
    $zip_util = array('gz'=>'gzip','bz2'=>'bzip2');
    if (array_key_exists($zip, $zip_util))
    {
      $fname = $dbName . '.' . date("w") . '.sql.' . $zip; 
      $this->cmd = 'mysqldump -u' . $dbUser . ' -p' . $dbPass .
          ' ' . $dbName . '| ' . $zip_util[$zip] . ' >' .
          $dest . '/' . $fname;
    }
    else
    {
      $fname = $dbName . '.' . date("w") . '.sql'; 
      $this->cmd = 'mysqldump -u' . $dbUser . ' -p' . $dbPass .
          ' ' . $dbName . ' >' . $dest . '/' . $fname;
    }
  }

}
?>