<?php

class IASTaxon extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'IASTaxons';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function scopeWithLanguageId($query, $languageId)
	{

		return $query->join('IASTaxonNames', 'taxonId', '=', 'id')
			->where('languageId', '=', $languageId);

	}

	public function scopeWithTaxonAndLanguageId($query, $taxonId, $languageId)
	{

		return $query->join('IASTaxonNames', 'taxonId', '=', 'id')
			->where('languageId', '=', $languageId)->where('taxonId', '=', $taxonId);

	}

	public function getChildTaxons()
	{

		$childs = IASTaxon::where('parentTaxonId', '=', $this->id)->get();
		if(NULL != $childs)
		{

			$childs = $childs->toArray();
			$childNum = count($childs);
			for($i=0; $i<$childNum; ++$i)
			{

				$aux = IASTaxon::where('parentTaxonId', '=', $childs[$i]["id"])->get();
				if(NULL != $aux)
				{

					$childs = array_merge($childs, $aux->toArray());
					$childNum = count($childs);

				}

			}

		}
		return $childs;

	}

	public function getChildTaxonsIds()
	{

		$ids = array();
		$childs = $this->getChildTaxons();;
		if(NULL != $childs)
		{

			$childNum = count($childs);
			for($i=0; $i<$childNum; ++$i)
			{

				$ids[] = $childs[$i]["id"];

			}

		}
		return $ids;

	}

	public function getName($languageId, $defaultLanguageId)
	{

		$taxonName = IASTaxonName::withIASTaxonAndLanguageId(
			$this->id, $languageId)->first();
		if(null == $taxonName)
		{

			$taxonName = IASTaxonName::withIASTaxonAndLanguageId(
				$this->id, $defaultLanguageId)->first();

		}

		return $taxonName->name;

	}

	function scopeLastUpdated($query)
	{

		return $query->orderBy('updated_at', 'DESC');

	}

}

?>