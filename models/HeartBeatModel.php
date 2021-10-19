<?php 

namespace Project\Models;
use Project\Core\BaseModel;
class HeartBeatModel extends BaseModel {

	public int $m_id;
	public int $m_userId;
	public int $m_heartBeat;
	public int $m_date;
}