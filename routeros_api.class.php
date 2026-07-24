<?php
class RouterosAPI {
    public $debug = false;
    public $connected = false;
    public $port = 8728;
    public $timeout = 3;
    public $attempts = 5;
    public $delay = 3;
    public $socket;
    public $error_no;
    public $error_str;

    public function connect($ip, $login, $password, $port = null) {
        if ($port !== null) {
            $this->port = $port;
        }
        for ($a = 1; $a <= $this->attempts; $a++) {
            $this->socket = @fsockopen($ip, $this->port, $this->error_no, $this->error_str, $this->timeout);
            if ($this->socket) {
                socket_set_timeout($this->socket, $this->timeout);
                $this->write('/login', false);
                $this->write('=name=' . $login, false);
                $this->write('=password=' . $password);
                $RESPONSE = $this->read(false);
                if (isset($RESPONSE[0]) && $RESPONSE[0] == '!done') {
                    $this->connected = true;
                    return true;
                }
            }
            sleep($this->delay);
        }
        return false;
    }

    public function disconnect() {
        if (is_resource($this->socket)) {
            fclose($this->socket);
        }
        $this->connected = false;
    }

    public function comm($com, $arr = array()) {
        $count = count($arr);
        $this->write($com, !$count);
        $i = 0;
        foreach ($arr as $key => $value) {
            $i++;
            $this->write('=' . $key . '=' . $value, ($i == $count));
        }
        return $this->read();
    }

    private function write($command, $param2 = true) {
        if ($command) {
            $data = explode("\n", $command);
            foreach ($data as $com) {
                $this->send_word(trim($com));
            }
            if ($param2) {
                $this->send_word('');
            }
        }
    }

    private function send_word($word) {
        $len = strlen($word);
        if ($len < 0x80) {
            fwrite($this->socket, chr($len));
        } elseif ($len < 0x4000) {
            fwrite($this->socket, chr(($len >> 8) | 0x80) . chr($len & 0xFF));
        }
        fwrite($this->socket, $word);
    }

    private function read($parse = true) {
        $RESPONSE = array();
        $receiveddone = false;
        while (!$receiveddone) {
            $byte = ord(fread($this->socket, 1));
            $length = 0;
            if ($byte & 0x80) {
                if (($byte & 0xC0) == 0x80) {
                    $length = (($byte & 0x3F) << 8) + ord(fread($this->socket, 1));
                }
            } else {
                $length = $byte;
            }
            $word = '';
            while ($length > 0) {
                $str = fread($this->socket, $length);
                $length -= strlen($str);
                $word .= $str;
            }
            if ($word == '!done') {
                $receiveddone = true;
            }
            $RESPONSE[] = $word;
        }
        return $parse ? $this->parse_response($RESPONSE) : $RESPONSE;
    }

    private function parse_response($response) {
        $parsed = array();
        $current = array();
        foreach ($response as $word) {
            if (strpos($word, '=') === 0) {
                $parts = explode('=', substr($word, 1), 2);
                if (count($parts) == 2) {
                    $current[$parts[0]] = $parts[1];
                }
            } elseif ($word == '!re' || $word == '!done') {
                if (!empty($current)) {
                    $parsed[] = $current;
                    $current = array();
                }
            }
        }
        return $parsed;
    }
}