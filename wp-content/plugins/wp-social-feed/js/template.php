<div class="social-feed-element {{? !it.moderation_passed}}hidden{{?}}" dt-create="{{=it.dt_create}}" social-feed-id = "{{=it.id}}">
    <div class='content'>
    <div class='text-wrapper'>
    <a href="{{=it.link}}" target="_blank" class="">{{=it.attachment}}</a>
        <p class="social-feed-text">{{=it.text}} <a href="{{=it.link}}" target="_blank" class="read-button">read more</a></p>
    </div>
        <a class="pull-left" href="{{=it.author_link}}" target="_blank">
            <img class="media-object" src="{{=it.author_picture}}">
        </a>
        <div class="media-body">
            <p>
                <strong><a style="font-weight: bold !important;" href="{{=it.author_link}}" target="_blank" ><span class="author-title">{{=it.author_name}}</span></a></strong>
            </p>
            <span class="muted pull-right"> {{=it.time_ago}}</span> 
        </div>
    </div>
</div>

