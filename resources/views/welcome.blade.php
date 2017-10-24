<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="{{ elixir('css/app.css') }}?t=<?=filemtime(public_path('css/app.css'))?>">
    </head>
    <body>
        <div id="app" class="flex-center position-ref full-height">
            <div class="content">
                <h1>
                    ProcessMaker
                </h1>
                <!-- seguimiento v-for="assignee in seguimientos" v-bind:model="assignee"/ -->
                <div v-for="assignee in seguimientos" class="row">
                    <div class="col-md-1" style="text-align:center;">
                        <img v-bind:src="assignee.avatar"><br>
                        @{{assignee.assignee}}
                    </div>
                    <div class="col-md-9">
                        <div v-for="issue in assignee.issues" class="issue">
                            <span class="issue-key"v-bind:style="{backgroundColor:issue.remainingTime<0?'lightpink':'lightskyblue'}"><a v-bind:href="'https://processmaker.atlassian.net/browse/'+issue.ticket">@{{issue.ticket}}</a></span>
                            <span class="issue-story-points">@{{issue.storyPoints}}</span>
                            <span class="issue-spent-time">@{{Math.round(issue.spentTime/3600*10)/10}}</span>
                            <span class="issue-progress"><span v-bind:style="{
                                width: (issue.spentTime/total(issue)*100)+'%',
                                backgroundColor: issue.remainingTime<0?'lightpink':'lightgreen'
                            }"></span><span v-bind:style="{
                                width: (colchon(issue)/total(issue)*100)+'%',
                                backgroundColor: 'white'
                            }"></span><span v-bind:style="{
                                width: (crTime(issue)/total(issue)*100)+'%',
                                backgroundColor: avance(issue)>estado('Code Review') ? 'lightgreen' : 'yellow'
                            }"></span><span v-bind:style="{
                                width: (ftTime(issue)/total(issue)*100)+'%',
                                backgroundColor: avance(issue)>estado('QA Sign-Off') ? 'lightgreen' : 'lightblue'
                            }"></span></span>
                            <span class="issue-status">@{{issue.status}}</span>
                            <span class="issue-remaining-time" v-bind:style="{color:issue.remainingTime<0?'red':'inherit'}">@{{Math.round(issue.remainingTime/3600*10)/10}}</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <span class="resume">
                            @{{Math.round(totalSpent(assignee)/3600*10)/10}} + (@{{Math.round(totalRemaining(assignee)/3600*10)/10}}) | @{{Math.round(totalColchon(assignee)/3600*10)/10}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ elixir('js/app.js') }}?t=<?=filemtime(public_path('js/app.js'))?>"></script>
    </body>
</html>
