<?php

class BMPSerializer {
    private static $p1 = "Qk06AAAAAAAAADYAAAAoAAAAAQAAAAEAAAABABgAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAA////AA==";
    private $out = null;
    public function __construct() {
        $this->out = base64_decode(self::$p1);
    }
    static public function base64_from_file($file) {
        return base64_encode(fread(fopen($file,'r'), filesize($file)));
    }
    public function convert_from_string($str) {
        $offset = ord($this->out[10]);
        $l = strlen($str);
        $cl = ceil($l/3);
        $w = sqrt($cl*5)/2;
        $w = ceil($w/4)*4;
        $h = ceil($cl/$w);
        $q = $w*$h;
        for($i=0,$j=$offset; $i<$l; $i++) {
            $this->out[$j++] = chr(ord($str[$i]));
        }
        for(; $j-$offset<$q*3;) {
            $this->out[$j++] = chr(0);
        }
        $this->out[$j++] = chr(13);
        $this->out[$j++] = chr(10);
        $this->update_width($w);
        $this->update_height($h);
        $this->update_image_size($q);
        $this->update_file_size($q*3+$offset+2);
    }
    public function convert_from_file($file) {
        $this->convert_from_string(file_get_contents($file));
    }
    private function update_file_size($n) {
        $this->out[2] = chr($n & 255);
        $this->out[3] = chr(($n >> 8) & 255);
        $this->out[4] = chr(($n >> 16) & 255);
        $this->out[5] = chr(($n >> 24) & 255);
    }
    private function update_width($n) {
        $this->out[18] = chr($n & 255);
        $this->out[19] = chr(($n >> 8) & 255);
        $this->out[20] = chr(($n >> 16) & 255);
        $this->out[21] = chr(($n >> 24) & 255);
    }
    private function update_height($n) {
        $this->out[22] = chr($n & 255);
        $this->out[23] = chr(($n >> 8) & 255);
        $this->out[24] = chr(($n >> 16) & 255);
        $this->out[25] = chr(($n >> 24) & 255);
    }
    private function update_image_size($n) {
        $this->out[34] = chr($n & 255);
        $this->out[35] = chr(($n >> 8) & 255);
        $this->out[36] = chr(($n >> 16) & 255);
        $this->out[37] = chr(($n >> 24) & 255);
    }
    public function write_file($file) {
        fwrite(fopen($file, "w"), $this->out);
    }
    public function get_base64_data() {
        return base64_encode($this->out);
    }
    public function stamp($soureFile, $xPos, $yPos, $str) {
        $ext = pathinfo($soureFile, PATHINFO_EXTENSION);
        switch($ext) {
        case 'jpg':
            $im = imagecreatefromjpeg($soureFile);
            break;
        case 'gif':
            $im = imagecreatefromgif($soureFile);
            break;
        case 'png':
            $im = imagecreatefrompng($soureFile);
            break;
        default:
            break;
        }
        if (!$im) return;
        $w = imagesx($im);
        $h = imagesy($im);
        $result = '';
        $xPos = ($xPos >= 0 && $xPos <$w)?$xPos:0;
        $yPos = ($yPos >= 0 && $yPos <$h)?$yPos:0;

        if (!imageistruecolor($im)) {
            $tmp = imagecreatetruecolor($w, $h);
            imagecopy($tmp, $im, 0, 0, 0, 0, $w, $h);
            imagedestroy($im);
            $im = & $tmp;
        }

        $biBPLine = $w * 3;
        $biStride = ($biBPLine + 3) & ~3;
        $biSizeImage = $biStride * $h;
        $bfOffBits = 54;
        $bfSize = $bfOffBits + $biSizeImage;

        $result .= substr('BM', 0, 2);
        $result .= pack ('VvvV', $bfSize, 0, 0, $bfOffBits);
        $result .= pack ('VVVvvVVVVVV', 40, $w, $h, 1, 24, 0, $biSizeImage, 0, 0, 0, 0);

        $numpad = $biStride - $biBPLine;
        for ($y = $h - 1; $y >= 0; --$y) {
            for ($x = 0; $x < $w; ++$x) {
                $col = imagecolorat ($im, $x, $y);
                $result .= substr(pack ('V', $col), 0, 3);
            }
            for ($i = 0; $i < $numpad; ++$i)
                $result .= pack ('C', 0);
        }

        imagedestroy($im);
        $this->out = $result;

        $l = strlen($str);
        for($i = 0, $j = $bfOffBits+$biStride*$yPos+$xPos; $i < $l; $i++) {
            $this->out[$j++] = chr(ord($str[$i]));
        }
    }
}
