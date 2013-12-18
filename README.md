Silverstripe Twitter Integration
================================

Allows you to integrate twitter with your Silverstripe website using twitter's
oauth authentication.

NOTE: This is currently a proof of concept, and only supports accessing latest
tweets in a template.

## Author
This module was created by [i-lateral](http://www.i-lateral.com).

Although this module can be extended with your own templates / JavaScript,
the default makes use of.

## Installation
Install this module either by downloading and adding to:

[silverstripe-root]/twitter

Then run: http://yoursiteurl.com/dev/build/

Or alternativly add to your projects composer.json

## Usage
Once installed, you have to setup your integration as a "application" on
[Twitter's dev site](https://dev.twitter.com).

Once this is done, you will need to add the relevent key's to your site's
siteconfig (settings) under "Twitter Integration".

Now, you can access the twitter object from your templates using $Twitter

## Accessing latest tweets
You can get an object set of tweets in your templates by using:

$Twitter.LatestTweets

Alternativley, you can get a rendered list by using:

$Twitter.RenderedLatestTweets
