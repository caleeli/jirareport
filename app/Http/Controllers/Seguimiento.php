<?php

namespace App\Http\Controllers;

use App\Jira;

class Seguimiento extends Controller
{

    public function addWorklog()
    {
        $main = new Jira(
            env('JIRA_URL'), env('JIRA_USER'), env('JIRA_PASSWORD')
        );
        date_default_timezone_set('America/La_Paz');
        $res = $main->api->addWorklog('HOR-3784', [
            'comment' => 'FT',
            'timeSpentSeconds' => 60*10,
            //'author' => "https:\/\/processmaker.atlassian.net\/rest\/api\/2\/user?username=paula",
            //'author' => "https:\/\/processmaker.atlassian.net\/rest\/api\/2\/user?username=david.callizaya",
            'author' => "https:\/\/processmaker.atlassian.net\/#definitions/user/david.callizaya",
        ]);
        dump($res);
    }

    public function getList()
    {
        $main = new Jira(
            env('JIRA_URL'),
            env('JIRA_USER'),
            env('JIRA_PASSWORD')
        );
        date_default_timezone_set('America/La_Paz');

        $jql = 'project in (Horus) AND Sprint in openSprints() AND assignee in '
            .'(roly.gutierrez, david.callizaya, jonathan.quispe, juliocesar, marco.antonio.nina, dante.loayza, paula) '
            .'ORDER BY updated DESC';

        $res = $main->api->search($jql,0,100,'*navigable,worklog');
        $issues = $res->getIssues();
        $result = [];
        foreach ($issues as $issue) {
            $fields = $issue->getFields();
            foreach($fields['Log Work']['worklogs'] as $wl) {
                $assignee = $wl['author'];
                $result[$assignee['displayName']]['avatar'] = $assignee['avatarUrls']['48x48'];
                $result[$assignee['displayName']]['assignee'] = $assignee['displayName'];
                $found = false;
                if(isset($result[$assignee['displayName']]['issues'])) {
                    foreach($result[$assignee['displayName']]['issues'] as $ii => $iss) {
                        if($iss['ticket'] === $issue->getKey()) {
                            $result[$assignee['displayName']]['issues'][$ii]['spentTime']+= $wl["timeSpentSeconds"];
                            $found = true;
                            break;
                        }
                    }
                }
                if(!$found) {
                    $result[$assignee['displayName']]['issues'][] = [
                        'ticket' => $issue->getKey(),
                        'storyPoints' => $fields['Story Points'],
                        'spentTime' => $wl["timeSpentSeconds"],
                        'estimateTime' => $fields['Σ Original Estimate'],//$fields['Σ Remaining Estimate'],
                        'remainingTime' => $fields['Σ Original Estimate']-$fields['Σ Time Spent'],//$fields['Σ Remaining Estimate'],
                        'status' => $fields['Status']['name'],
                    ];
                }
            }
        }
        $response = response()->json(array_values($result));
        $minutes = 1;
        $response->setLastModified(new \DateTime('now'));
        $response->setExpires(\Carbon\Carbon::now()->addMinutes($minutes));
        return $response;
    }
}
