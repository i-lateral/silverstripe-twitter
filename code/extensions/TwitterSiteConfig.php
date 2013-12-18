<?php

class TwitterSiteConfig extends DataExtension {
    public static $db = array(
        'TwitterUserName'           => 'Varchar(100)',
        'TwitterConsumerKey'        => 'Varchar(100)',
        'TwitterConsumerSecret'     => 'Varchar(100)',
        'TwitterAccessToken'        => 'Varchar(100)',
        'TwitterAccessTokenSecret'  => 'Varchar(100)'
    );

    function updateCMSFields(FieldList $fields) {
        $social_fields = ToggleCompositeField::create('TwitterIntegration', 'Twitter Integration',
            array(
                TextField::create('TwitterUserName', $this->owner->fieldLabel('TwitterUserName')),
                TextField::create('TwitterConsumerKey', $this->owner->fieldLabel('TwitterConsumerKey')),
                TextField::create('TwitterConsumerSecret', $this->owner->fieldLabel('TwitterConsumerSecret')),
                TextField::create('TwitterAccessToken', $this->owner->fieldLabel('TwitterAccessToken')),
                TextField::create('TwitterAccessTokenSecret', $this->owner->fieldLabel('TwitterAccessTokenSecret'))
            )
        )->setHeadingLevel(4);

        $fields->addFieldToTab('Root.Main', $social_fields);
    }
}
