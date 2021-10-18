<?php

namespace Project\Models;

class MinigameResultModel extends BaseModel {

	public int $m_id;
	public int $m_userId;
	public int $m_dayMood;
	public int $m_daySleep;
	public int $m_noiseDayMood;
	public int $m_noiseNightMood;
	public int $m_breathing;
	public bool $m_wentOutside;
	public bool $m_interactiveDay;
	public bool $m_sport;
	public bool $m_sportIndoor;
	public bool $m_sportHarder;
	public int $m_sportDuration;

	public function getAuthor(): UserModel {
		return UserModel::findOne($this->m_userId);
	}
}