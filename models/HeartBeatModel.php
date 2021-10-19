<?php 

namespace Project\Models;
use Project\Core\BaseModel;

/**
 * model for the heart beat
 */
class HeartBeatModel extends BaseModel {

	public int $m_id;
	public int $m_userId;
	public int $m_heartBeat;
	public int $m_date;
}