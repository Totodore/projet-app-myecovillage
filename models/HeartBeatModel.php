<?php 

namespace Project\Models;
class HeartBeatModel extends BaseModel {

	public int $m_id;
	public int $m_userId;
	public UserModel $l_user;
	public int $m_heartBeat;
	public int $m_date;
}