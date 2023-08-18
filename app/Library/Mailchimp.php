<?php

namespace App\Library;

use MailchimpMarketing;

class Mailchimp {
    private $client;

    public $listId;

	public function __construct() {
		$this->client = new MailchimpMarketing\ApiClient();
        $this->connect();
        $this->listId = $this->geDefaulttList();
	}

    public function connect() {
        $this->client->setConfig([
            'apiKey' => env('MAILCHIMP_API_KEY'),
            'server' => env('MAILCHIMP_SERVER_PREFIX')
        ]);
    }

    public function test() {
        return $this->client->ping->get()->health_status == 'Everything\'s Chimpy!';
    }

    public function geDefaulttList() {
        return $this->listId = env('MAILCHIMP_DEFAULT_LIST_ID');
    }

    public function addListMember(string $listId, object $member) {
        return $this->client->lists->addListMember($listId, [
            'email_address' => $member->email,
            'status' => 'subscribed',
            'tags' => [$member->userSubscribedPlans?->subscription->plan_name ?? 'Free'],
            'merge_fields' => [
                'FNAME' => $member->first_name,
                'LNAME' => $member->last_name,
                'PHONE' => $member->phone_number,
                'USER_ID' => $member->id,
                'PLAN_ID' => 0,
                'PLAN_NAME' => 'Free'
            ]
        ]);
    }

    public function updateListMember(string $listId, object $member) {
        $this->removeAllTags($listId, $member->mailchimp_id);

        return $this->client->lists->updateListMember($listId, $member->mailchimp_id, [
            'email_address' => $member->email,
            'status' => 'subscribed',
            'tags' => [$member->userSubscribedPlans?->subscription->plan_name],
            'merge_fields' => [
                'FNAME' => $member->first_name,
                'LNAME' => $member->last_name,
                'PHONE' => $member->phone_number,
                'USER_ID' => $member->id,
                'PLAN_ID' => $member->getUserSubscription($member->id)?->subscription->id,
                'PLAN_NAME' => $member->getUserSubscription($member->id)?->subscription->plan_name
            ]
        ]);
    }

    public function removeAllTags(string $listId, string $memberMailchimpId) {
        $response = $this->client->lists->getListMemberTags($listId, $memberMailchimpId);

        $tagMaps = function ($tag) {
            return ['name' => $tag->name, 'status' => 'inactive'];
        };

        $tags = array_map($tagMaps, $response->tags);

        return $this->client->lists->updateListMemberTags($listId, $memberMailchimpId, ['tags' => $tags]);
    }

    public function __invoke() {
        return $this->client;
    }
}
