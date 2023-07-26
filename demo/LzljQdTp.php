<?php




class LzljQdTp implements ThirdPartyPromise
{

    public function component_appid()
    {
        return 'component_appid';
    }

    public function component_appsecret()
    {
        return 'component_appsecret';
    }

    public function component_verify_ticket()
    {
        $ticket = Crud::db()->select('tpp', 'InfoType = "component_verify_ticket"')->order('CreateTime DESC')->prep()->one();
        return $ticket['ComponentVerifyTicket'];
    }

    public function post($url, $params): array
    {
        $rsp = Lite::request()->post($url, json_encode($params));
        return json_decode($rsp, true);
    }

    public function get_pre_auth_code()
    {
        $data = Crud::db()->select('tpp_component', 'AppId = ?')->prep($this->component_appid())->one();
        if (!empty($data['pre_auth_code_expire_at']) && $data['pre_auth_code_expire_at'] > time()) {
            return $data['pre_auth_code'];
        }

        $arr = (new ThirdParty(new self()))->api_create_preauthcode();
        Crud::db()->updateOrInsert(
            'tpp_component',
            ['AppId' => $this->component_appid()],
            [
                'pre_auth_code' => $arr['pre_auth_code'],
                'pre_auth_code_expire_at' => time() + 1600,
            ]
        );
        return $arr['pre_auth_code'];
    }

    public function get_component_access_token()
    {
        $data = Crud::db()->select('tpp_component', 'AppId = ?')->prep($this->component_appid())->one();
        if (!empty($data['expire_at']) && $data['expire_at'] > time()) {
            return $data['component_access_token'];
        }

        $arr = (new ThirdParty(new self()))->api_component_token();
        Crud::db()->updateOrInsert(
            'tpp_component',
            ['AppId' => $this->component_appid()],
            [
                'component_access_token' => $arr['component_access_token'],
                'expire_at' => time() + 7000,
            ]
        );
        return $arr['component_access_token'];
    }

    public function get_authorizer_access_token($authorizer_appid)
    {
        $field = 'authorizer_access_token,authorizer_refresh_token,expire_at';
        $data = Crud::db()->select('tpp_authorizer_token', 'authorizer_appid = ?', $field)->prep($authorizer_appid)->one();
        if (!empty($data['expire_at']) && $data['expire_at'] > time()) {
            return $data['authorizer_access_token'];
        }

        $arr = (new ThirdParty(new self()))->refresh_authorizer_token($authorizer_appid, $data['authorizer_refresh_token']);
        $sql_data = [
            'authorizer_access_token' => $arr['authorizer_access_token'],
            'authorizer_refresh_token' => $arr['authorizer_refresh_token'],
            'expire_at' => time() + 7000,
        ];
        Crud::db()->update('tpp_authorizer_token', $sql_data, 'authorizer_appid = ?', [$authorizer_appid]);
        return $arr['authorizer_access_token'];
    }
}