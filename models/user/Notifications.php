<?php

class Notification extends 
    /**
     * Returns default auth clients list.
     * @return NotificationTransportInterface[] auth clients list.
     */
    protected function defaultTransports()
    {
		/**
		 * @var string name of the auth client collection application component.
		 * This component will be used to fetch services value if it is not set.
		 */
		public $clientCollection = 'authClientCollection';
		
		private $_transports;
		
        /* @var $collection \app\modules\notifications\Collection */
        $collection = Yii::$app->get($this->clientCollection);

        return $collection->getClients();
    }
