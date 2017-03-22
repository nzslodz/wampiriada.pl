<?php namespace NZS\Core\Contracts;
use NZS\Core\Polls\Poll;

interface PollClass {
    public function resolveInterface($contract, Poll $poll);

    /*
     * Allow entering multiple responses for this poll.
     * If set to false, a cookie will be set to prevent multiple entries,
     * and if enablePersonMatching is true it will try to prevent answers attributed to the same person.
     */
    public function allowMultipleResponses();

    /*
     * Try to find person that this poll would be attributed to.
     * If set to true, a mechanism will try to determine the Person by checking if user is logged in,
     * via campaign token and through e-mail matching if emailField is set.
     * This mechanism will implicitly create new Person objects if no matching Person was found.
     *
     * Set to false to disable this mechanism and effectively make polls anonymous.
     *
     * The emailField() should return name of the email field or null.
     */
    public function enableTracking();
    public function emailField();

    /*
     * Allow anonymous responses.
     * If set to false, the form will not allow unlogged persons to respond to the poll.
     * However, if the emailField() is not null, the poll will be displayed publicly.
     * In order to prevent that behaviour, set allowAnonymousDisplay() to false.
     */
    public function allowAnonymousResponses();
    public function allowAnonymousDisplay();

    /*
     * Get list of query parameters that can be passed to the form and saved later in the answer.
     */
    public function allowedQueryParameters();
}
