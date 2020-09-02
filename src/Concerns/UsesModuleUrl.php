<?php


namespace BristolSU\ApiToolkit\Concerns;

use BristolSU\ApiToolkit\Contracts\HttpClient;

trait UsesModuleUrl
{

    private $usesModuleUrl = false;

    private $userId;

    private $groupId;

    private $roleId;

    private $activityInstanceId;

    private $activitySlug;

    private $moduleInstanceSlug;

    private $apiType = 'p';
    /**
     * @var string
     */
    private $moduleAlias;

    /**
     * Set the ID of the user to act as
     *
     * @param int $userId
     * @return self
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Set the ID of the group to act in.
     *
     * @param int $groupId
     * @return self
     */
    public function setGroupId(int $groupId)
    {
        $this->groupId = $groupId;
        return $this;

    }

    /**
     * Set the ID of the role to act in
     *
     * @param int $roleId
     * @return self
     */
    public function setRoleId(int $roleId)
    {
        $this->roleId = $roleId;
        return $this;

    }

    /**
     * Set the activity instance ID.
     *
     * Will default to the first available activity instance
     *
     * @param int $activityInstanceId
     * @return self
     */
    public function setActivityInstance(int $activityInstanceId)
    {
        $this->activityInstanceId = $activityInstanceId;
        return $this;

    }

    /**
     * Set the module instance slug
     *
     * @param string $slug
     * @return self
     */
    public function setModuleInstance(string $slug)
    {
        $this->moduleInstanceSlug = $slug;
        return $this;

    }

    /**
     * Set the activity slug
     *
     * @param string $slug
     * @return self
     */
    public function setActivity(string $slug)
    {
        $this->activitySlug = $slug;
        return $this;

    }

    public function admin()
    {
        $this->apiType = 'a';
        return $this;

    }

    public function participant()
    {
        $this->apiType = 'p';
        return $this;

    }

    protected function usesModuleUrl(string $moduleAlias)
    {
        $this->moduleAlias = $moduleAlias;
        $this->usesModuleUrl = true;
    }

    protected function usesModuleUrlCanHandle(HttpClient $httpClient): bool
    {
        return $this->usesModuleUrl;
    }

    protected function usesModuleUrlPreRequest(HttpClient $httpClient, string $uri)
    {
        $httpClient->config()->addQuery(
          $this->getModuleUrlQuery()
        );

        $uri = (strncmp($uri, '/', 1) === 0 ? $uri : '/' . $uri);
        return $this->getModuleUrlPath() . $uri;
    }

    private function getModuleUrlQuery(): array
    {
        if (!$this->userId) {
            throw new \Exception('A user ID must be set using setUserId($id)');
        }
        if (!$this->activityInstanceId) {
            throw new \Exception('An activity instance must be set using setUserId($id)');
        }
        $query = [
          'user_id' => $this->userId
        ];
        if ($this->groupId) {
            $query['group_id'] = $this->groupId;
        }
        if ($this->roleId) {
            $query['role_id'] = $this->roleId;
        }
        if ($this->activityInstanceId) {
            $query['activity_instance_id'] = $this->activityInstanceId;
        }
        return $query;
    }

    private function getModuleUrlPath()
    {
        if (!$this->activitySlug) {
            throw new \Exception('An activity slug must be set through setActivity($activitySlug)');
        }
        if (!$this->moduleInstanceSlug) {
            throw new \Exception('A module instance slug must be set through setModuleInstance($moduleInstanceSlug)');
        }
        if (!$this->moduleAlias) {
            throw new \Exception('A module alias must be set by the developer.');
        }
        return sprintf('/api/%s/%s/%s/%s', $this->apiType, $this->activitySlug, $this->moduleInstanceSlug, $this->moduleAlias);
    }
}
