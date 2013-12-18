<div class="twitter-container">
    <% if $Tweets %>
        <div class="twitter-tweets">
            <% loop $Tweets %>
                <div class="row container">
                    <div class="tweet-pic third">
                        <a href="http://twitter.com/{$User.ScreenName}" title="View this user profile on Twitter">
                            <img src="$User.ProfileImg" alt="$User.Name"/>
                        </a>
                    </div>

                    <div class="twitter-tweet twothird">
                        <p>
                            <a
                                href="http://twitter.com/{$User.ScreenName}/statuses/{$ID}"
                                title="View this tweet on Twitter"
                            >
                                $Date.Ago
                            </a>
                            $Content
                        </p>
                    </div>
                </div>
            <% end_loop %>
        </div>
    <% else %>
        <p>No current tweets</p>
    <% end_if %>

    <p class="follow"><a class="btn" href="https://twitter.com/{$SiteConfig.TwitterUserName}">Follow on Twitter</a></p>
</div>
