<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Uploader
{
    private $filename;    
    private $dest_folder;

    public function __construct($dest_folder='kits', $save_filename='new')
    {
        $this->filename = '';
        $this->dest_folder = $dest_folder;        
        if (!file_exists($this->dest_folder)) {
            mkdir($this->dest_folder, 0777, true);
        }
    }

    function uploadKit() 
    {
        if(isset($_POST['submit'])){
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $isZipExtension = ( $extension == "zip" ? true : false );
            $zipTypes = array('application/zip', 'application/x-zip-compressed', 
            'multipart/x-zip', 'application/x-compressed');
            $isZipFile = in_array( $_FILES['file']["type"], $zipTypes );            
    
            if( $isZipFile && $isZipExtension) {
                $dst_path = __DIR__.'/'.$this->sanitizeFilename($_FILES['file']['name']);                
                $src_path = $_FILES['file']['tmp_name'];
                echo 'SRC => '.$src_path.' | DST => '.$dst_path.'<br>';
                move_uploaded_file($src_path, $dst_path);
                $this->filename = realpath($dst_path);                
            }
        }
    }

    public static function clean($dest_folder)
    {
        //Get a list of all of the file names in the folder.
        $files = glob($dest_folder . '/*');
        print_r($files);
        foreach($files as $file) {
            if (is_file($file)) {
                unlink($file);                
            } else {                
                Uploader::clean($file);
            }
        }
        rmdir($dest_folder);
        echo 'Should have been cleaned';
    }

    static function sanitizeFilename($filename)
    {
        return preg_replace( '/[\r\n\t -]+/', '-', $filename );
    }

    function prepareKit()
    {
        echo 'Prepare kit';
        $zip = new ZipArchive;        
        $res = $zip->open($this->filename);
        if (isset($_POST['save_folder'])) {
            $save_folder = $this->dest_folder.'/'.$_POST['save_folder'];            
            if (!file_exists($save_folder)) {
                mkdir($save_folder, 0777, true);
            }
        } else {
            $save_folder = $this->dest_folder;            
        }        
        if ($res === TRUE) {
            // extract it to the path we determined above
            $zip->extractTo($save_folder);
            $zip->close();
            unlink($this->filename);
            echo "WOOT! $this->filename extracted to $this->dest_folder";
            $this->backHome();
        } else {
            echo "Doh! I couldn't open $this->filename";
        }
    }

    static function backHome()
    {
        header("Location: index.php");
    }
}

$uploader = new Uploader;
$uploader->uploadKit();
$uploader->prepareKit();
// Uploader::clean('kits');
?>