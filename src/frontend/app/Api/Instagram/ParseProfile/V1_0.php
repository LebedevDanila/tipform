<?php

namespace App\Api\Instagram\ParseProfile;

use \App\Libraries\Utils\Output;
use Config\Database;
use App\Libraries\Api;
use Config\Services;
use App\Jobs\Instagram\ParserInstanavigation;
use App\Jobs\Instagram\ParserStoriesigInfo;

class V1_0
{

    private $profile;

    public function __construct()
    {
        $this->output = new Output();
        $this->db     = Database::connect();
        $this->cache  = Services::cache();
    }

    /**
     * Код функции
     */
    public function execute($params = [])
    {
        if ( ! isset($params['username']) || ! isset($params['load'])) {
            return $this->output->error(11);
        }

        if ( ! preg_match('/^[a-zA-Z0-9_.]{1,30}$/', $params['username'])) {
            return $this->output->error(390);
        }

        $parse_profile = 'parse.' . $params['username'];
        $in_parse   = $this->cache->get($parse_profile);
        if ( ! empty($in_parse)) {
            return $this->output->error(777);
        } else {
            $this->cache->save($parse_profile, true, 20);
        }

        $try          = 5;
        $count_errors = 0;
        for ($i = 0; $i < $try; $i++) {
            $account = (new Api())->call('account.getByLastAction');
            if ( ! empty($account->error)) {
                return $this->output->error($account->error->code);
            }

            /*$parser_key = 'instagram.parser';
            $parser     =  $this->cache->get($parser_key);
            if ($parser === 'Instanavigation') {
                $instagram = (new ParserInstanavigation(
                    [
                        'username' => $params['username'],
                        'proxy'    => [
                            'ip'       => $account->proxy_ip,
                            'login'    => $account->proxy_login,
                            'password' => $account->proxy_password,
                        ],
                    ]
                ))->call('data');

                $this->cache->save($parser_key, 'StoriesigInfo', 180);
            } else {
                $instagram = (new ParserStoriesigInfo(
                    [
                        'username' => $params['username'],
                        'proxy'    => [
                            'ip'       => $account->proxy_ip,
                            'login'    => $account->proxy_login,
                            'password' => $account->proxy_password,
                        ],
                    ]
                ))->getData();

                $this->cache->save($parser_key, 'Instanavigation', 180);
            }*/

            $instagram = (new ParserInstanavigation(
                [
                    'username' => $params['username'],
                    'proxy'    => [
                        'ip'       => $account->proxy_ip,
                        'login'    => $account->proxy_login,
                        'password' => $account->proxy_password,
                    ],
                ]
            ))->call('data');

            if ( ! empty($instagram->error)) {
                if ($instagram->error->code == 380) {
                    return $this->output->error(380);
                }
                if ($instagram->error->code == 385) {
                    return $this->output->error(385);
                }
                $count_errors++;
            } else {
                break;
            }
        }
        if ($count_errors >= $try) {
            return $this->output->error(333);
        }

        $instagram      = $instagram->response->data;
        $this->profile  = $instagram;
        $client_stories = $instagram->stories;

        $this->profile->id = $params['profile_id'];
        if ($params['load'] === 'ALL') {
            $saved_profile = (new Api())->call(
                'instagram.saveProfile',
                [
                    'unique_id'   => $this->profile->unique_id,
                    'username'    => $this->profile->username,
                    'biography'   => $this->profile->biography,
                    'picture'     => $this->profile->picture,
                    'followers'   => $this->profile->followers,
                    'following'   => $this->profile->following,
                    'verified'    => $this->profile->verified ? 1 : 0,
                    'private'     => $this->profile->private ? 1 : 0,
                    'media_count' => $this->profile->media_count,
                ]
            );
            if ( ! empty($saved_profile->error)) {
                return $this->output->error($saved_profile->error->code);
            }
            $this->profile = $saved_profile;
        } else {
            $this->db
                ->table('instagram_profiles')
                ->where('unique_id', $this->profile->unique_id)
                ->set('date_update', time())
                ->update();
            $this->profile->picture = PROXY_WORKER_URL . $this->profile->picture;
        }

        if ($params['load'] !== 'NONE') {
            $new_stories   = [];
            $local_stories = $this->db
                ->table('instagram_stories')
                ->where('profile_id', $this->profile->id)
                ->get()->getResult();
            foreach ($client_stories as $client_story) {
                $search = false;
                foreach ($local_stories as $local_story) {
                    if ((string)$client_story->unique_id === (string)$local_story->unique_id) {
                        $search = true;
                        break;
                    }
                }
                if ($search === false) {
                    $new_stories[] = $client_story;
                }
            }

            if ( ! empty($new_stories)) {
                $save_stories = (new Api())->call(
                    'instagram.saveStoryList',
                    [
                        'data'             => $new_stories,
                        'profile_id'       => $this->profile->id,
                        'profile_username' => $this->profile->username,
                    ]
                );
                if ( ! empty($save_stories->error)) {
                    return $this->output->error($save_stories->error->code);
                }
            }
        }

        $this->profile->parser = $parser;
        return $this->output->collection($this->profile);
    }

}
