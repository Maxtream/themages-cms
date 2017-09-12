<?php
$auth = function ($request, $response, $next) {
    $request = $request->withAttribute('isLogged', false);
    
    // Check if sessionToken header is in the call
    if ($request->hasHeader('sessionToken')) {
        // Header exist, check in Db
        $sessionToken = $request->getHeader('sessionToken')[0];

        $q = $this->db->prepare(
            'SELECT `a`.`id`, `a`.`login`, `a`.`email`, `a`.`level`, `a`.`custom_access` '.
            'FROM `mo_users_auth` AS `ua` '.
            'LEFT JOIN `mo_admins` AS `a` ON `ua`.`user_id` = `a`.`id` '.
            'WHERE `ua`.`token` = :sessionToken '.
            'LIMIT 1'
        );
        $q->bindParam(':sessionToken', $sessionToken, PDO::PARAM_STR);
        $q->execute();
        $user = $q->fetch(PDO::FETCH_OBJ);

        // Session token not found in db, probably someone messing or it expired
        if ($user) {
            $request = $request->withAttribute('isLogged', true);
            $request = $request->withAttribute('user', $user);

            $breakdown = explode('/', $request->getUri()->getPath());
            $path = $breakdown[2];
        
            // Fetching permissions
            $q = $this->db->query('SELECT `value` FROM `mocms` WHERE `setting` = "menu"');
            $q->execute();
            $permissions = $q->fetch();
            $permissions = json_decode($permissions['value']);
            $key = array_search($path, array_column($permissions, 'key'));
            $level = $permissions[$key]->level;
    
            // Check if user level is enough to use this API endpoint
            if ($user->level < $level) {
                $response = $response->withStatus(403);
                $data = array('message' => 'Access denied');
                
                return $response->withJson($data);
            }
        }
    }

    $response = $next($request, $response);
    
    return $response;
};