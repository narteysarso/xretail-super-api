<?php 


namespace Core\Domain\Entity;


class SubscriptionCode extends AppEntity {

    protected $code;
    protected $days;
    private $DEFAULT_DAYS = '30';

    public function __construct(array $data, $uuid)
    {
        $this->setUUID($uuid);

        !array_key_exists('id', $data) ? $this->setId("") : $this->setId($data['id']);

        !array_key_exists('code', $data) ? $this->setCode() : $this->setCode($data['code']);

        !array_key_exists('days', $data) ? $this->setDays() : $this->setDays($data['days']);

        array_key_exists('app_id', $data) && $this->setAppId($data['app_id']);

        array_key_exists('created_at', $data) && $this->setCreatedAt($data['created_at']);

        array_key_exists('updated_at', $data) && $this->setUpdatedAt($data['updated_at']);

        array_key_exists('deleted_at', $data) && $this->setDeletedAt($data['deleted_at']);
    }


    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode(String $code = "")
    {
        $this->code = trim($code) !== "" ? $code:  SubscriptionCode::makeCode();
        

        return $this;
    }

    private static function makeCode(): String {
        $original_string = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        $original_string = implode("", $original_string);
        return substr(str_shuffle($original_string.time()), 0, 16);
        
    }

    /**
     * Set the value of days
     *
     * @return  self
     */ 
    public function setDays($days = 30)
    {
        $this->days = $days;

        return $this;
    }
}