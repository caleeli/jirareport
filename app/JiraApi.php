<?php

namespace App;

use chobie\Jira\Api;

/**
 * Description of JiraApi
 *
 * @author davidcallizaya
 */
class JiraApi extends Api
{
	/**
	 * Adds a new worklog entry to an issue.
	 *
     * {
     *     "id": "https://docs.atlassian.com/jira/REST/schema/worklog#",
     *     "title": "Worklog",
     *     "type": "object",
     *     "properties": {
     *         "author": {
     *             "$ref": "#/definitions/user"
     *         },
     *         "updateAuthor": {
     *             "$ref": "#/definitions/user"
     *         },
     *         "comment": {
     *             "type": "string"
     *         },
     *         "created": {
     *             "type": "string"
     *         },
     *         "updated": {
     *             "type": "string"
     *         },
     *         "visibility": {
     *             "title": "Visibility",
     *             "type": "object",
     *             "properties": {
     *                 "type": {
     *                     "type": "string",
     *                     "enum": [
     *                         "group",
     *                         "role"
     *                     ]
     *                 },
     *                 "value": {
     *                     "type": "string"
     *                 }
     *             },
     *             "additionalProperties": false
     *         },
     *         "started": {
     *             "type": "string"
     *         },
     *         "timeSpent": {
     *             "type": "string"
     *         },
     *         "timeSpentSeconds": {
     *             "type": "integer"
     *         },
     *         "id": {
     *             "type": "string"
     *         },
     *         "issueId": {
     *             "type": "string"
     *         },
     *         "properties": {
     *             "type": "array",
     *             "items": {
     *                 "title": "Entity Property",
     *                 "type": "object",
     *                 "properties": {
     *                     "key": {
     *                         "type": "string"
     *                     },
     *                     "value": {}
     *                 },
     *                 "additionalProperties": false
     *             }
     *         }
     *     },
     *     "definitions": {
     *         "user": {
     *             "title": "User",
     *             "type": "object",
     *             "properties": {
     *                 "name": {
     *                     "type": "string"
     *                 },
     *                 "key": {
     *                     "type": "string"
     *                 },
     *                 "accountId": {
     *                     "type": "string"
     *                 },
     *                 "emailAddress": {
     *                     "type": "string"
     *                 },
     *                 "avatarUrls": {
     *                     "type": "object",
     *                     "patternProperties": {
     *                         ".+": {
     *                             "type": "string"
     *                         }
     *                     },
     *                     "additionalProperties": false
     *                 },
     *                 "displayName": {
     *                     "type": "string"
     *                 },
     *                 "active": {
     *                     "type": "boolean"
     *                 },
     *                 "timeZone": {
     *                     "type": "string"
     *                 }
     *             },
     *             "additionalProperties": false,
     *             "required": [
     *                 "active"
     *             ]
     *         }
     *     },
     *     "additionalProperties": false
     * }
     *
	 * @param string $issue_key Issue key should be "YOURPROJ-22".
	 * @param array  $params    Params.
	 *
	 * @return Result|false
	 */
	public function addWorklog($issue_key, array $params)
	{
		return $this->api(self::REQUEST_POST, sprintf('/rest/api/2/issue/%s/worklog', $issue_key), $params);
	}

}
