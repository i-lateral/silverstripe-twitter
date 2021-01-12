<?php

namespace ilateral\Twitter\Extension;

use SilverStripe\Core\Extension;
use ilateral\Twitter\Control\Twitter;

class TwitterController extends Extension
{
    /**
     * Factory method for getting the twitter controller
     */
    public function Twitter()
    {
        return new Twitter();
    }
}
