<?php

namespace MediavisieBv\MarketingApi\Models\Objects;

class Profile
{
    public $id;
    public $organisationId;
    public $foreignId;
    public $email;
    public $phonenumber;
    public $mobilenumber;

    /** @var \MediavisieBv\MarketingApi\Models\ProfileGender */
    public $gender;
    public $firstname;
    public $lastname;
    public $insertion;
    public $streetname;
    public $housenumber;
    public $housenumberAddition;
    public $zipcode;
    public $city;
    public $country;

    /** @var array */
    public $properties;
}