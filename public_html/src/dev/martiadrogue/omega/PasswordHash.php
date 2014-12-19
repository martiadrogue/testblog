<?php
namespace dev\martiadrogue\omega;

class PasswordHash {

  const SALT_BYTE_SIZE = 24;
  const HASH_ALGORITHM = "sha256";
  const HASH_ITERATIONS = 1000;
  const HASH_BYTE_SIZE = 24;

  const HASH_ALGORITHM_INDEX = 0;
  const HASH_ITERATION_INDEX = 1;
  const HASH_SALT_INDEX = 2;
  const HASH_PBKDF2_INDEX = 3;

  function __construct() {
  }

/**
 * Encript the password. To use this function is necessari php has package
 * php-mcrypt installed, from repositori,
 * http://www.mirrorservice.org/sites/dl.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm
 *
 * @param  string $password A chain of chars to encript
 * @return string           The password encripted.
 */
  public function create_hash($password) {
    // format: algorithm:iterations:salt:hash
    $iv = mcrypt_create_iv(self::SALT_BYTE_SIZE, MCRYPT_DEV_URANDOM);
    $salt = base64_encode($iv);
    $pbkdf2 = hash_pbkdf2(self::HASH_ALGORITHM, $password, $salt, self::HASH_ITERATIONS, self::HASH_BYTE_SIZE, true);
    $hash = base64_encode($pbkdf2);
    return self::HASH_ALGORITHM .':'. self::HASH_ITERATIONS .':'. $salt .':'. $hash;
  }

  public function validate_password($password, $correct_hash) {
    $params = explode(":", $correct_hash);
    $correct_pbkdf2 = base64_decode($params[self::HASH_PBKDF2_INDEX]);
    $pbkdf2 = hash_pbkdf2($params[self::HASH_ALGORITHM_INDEX], $password, $params[self::HASH_SALT_INDEX], (int)$params[self::HASH_ITERATION_INDEX], strlen($correct_pbkdf2), true);
    return $this->slow_equals($correct_pbkdf2, $pbkdf2);
  }

  /** Compares two strings $a and $b in length-constant time. */
  private function slow_equals($a, $b) {
    $diff = strlen($a) ^ strlen($b);
    for($i = 0; $i < strlen($a) && $i < strlen($b); $i++) {
      $diff |= ord($a[$i]) ^ ord($b[$i]);
    }
    return $diff === 0;
  }
}
