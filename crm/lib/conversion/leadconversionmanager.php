<?php
namespace Bitrix\Crm\Conversion;

class LeadConversionManager
{
	/** @var bool  */
	protected $isReturnCustomer = true;

	/** @var null|static  */
	protected static $instance = null;

	public function __construct(array $params)
	{
		$this->initialize($params);
	}

	protected function initialize(array $params)
	{
		if (isset($params['IS_RC']) && ($params['IS_RC'] === true || $params['IS_RC'] === 'Y'))
		{
			$this->isReturnCustomer = true;
		}
		else
		{
			$this->isReturnCustomer = false;
		}

		return $this;
	}

	/**
	 * Create.
	 *
	 * @param array $params
	 * @return static
	 */
	public static function create(array $params)
	{
		if (self::$instance === null)
		{
			self::$instance = new static($params);
		}
		else
		{
			self::$instance->initialize($params);
		}

		return self::$instance;
	}

	public function getDefaultConfig()
	{
		if ($this->isReturnCustomer)
		{
			return RCLeadConversionConfig::getDefault();
		}
		else
		{
			return LeadConversionConfig::getDefault();
		}
	}

	public function getConfig()
	{
		if ($this->isReturnCustomer)
		{
			$config = RCLeadConversionConfig::load();
		}
		else
		{
			$config = LeadConversionConfig::load();
		}

		if($config)
		{
			return $config;
		}

		if ($this->isReturnCustomer)
		{
			$config = RCLeadConversionConfig::getDefault();
		}
		else
		{
			$config = LeadConversionConfig::getDefault();
		}

		return $config;
	}

	public function getCurrentSchemeID()
	{
		if ($this->isReturnCustomer)
		{
			return RCLeadConversionConfig::getCurrentSchemeID();
		}
		else
		{
			return LeadConversionConfig::getCurrentSchemeID();
		}
	}

	public function getSchemeJsDescriptions($checkPermissions = false)
	{
		if ($this->isReturnCustomer)
		{
			return RCLeadConversionScheme::getJavaScriptDescriptions($checkPermissions);
		}
		else
		{
			return LeadConversionScheme::getJavaScriptDescriptions($checkPermissions);
		}
	}
}