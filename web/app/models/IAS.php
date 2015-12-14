<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class IAS extends Eloquent {

	use SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'IAS';
	protected $softDelete = true;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('creatorId', 'created_at', 'updated_at');

	public function getDefaultImageData($languageId, $defaultLanguageId)
	{

		$obj = new stdClass();
		$langs = Language::all();

		if(null != $this->defaultImageId)
		{

			$img = IASImage::find($this->defaultImageId);
			$obj->url = $img->URL;
			$obj->attribution = $img->attribution;
			$obj->rotation = $img->rotation;
			$imgText = IASImageText::withIASImageAndLanguageId(
				$img->id, $languageId)->first();
			if(null == $imgText)
			{

				$imgText = IASImageText::withIASImageAndLanguageId(
					$img->id, $defaultLanguageId)->first();

			}

			if(null != $imgText)
				$obj->text = $imgText->text;
			else
				$obj->text = "";

			$obj->texts = array();
			for($i=0; $i<count($langs); ++$i)
			{

				$imgText = IASImageText::withIASImageAndLanguageId(
					$img->id, $langs[$i]->id)->first();
				if(null == $imgText)
				{

					$imgText = IASImageText::withIASImageAndLanguageId(
						$img->id, $defaultLanguageId)->first();

				}

				if(null != $imgText)
					$obj->texts[$langs[$i]->locale] = $imgText->text;
				else
					$obj->texts[$langs[$i]->locale] = "";

			}

		}

		return $obj;

	}

	public function getImageData($languageId, $defaultLanguageId)
	{

		$data = array();
		$images = IASImage::withIASId($this->id)->get();
		$langs = Language::all();

		for($i=0; $i<count($images); ++$i)
		{

			$obj = new stdClass();
			$img = $images[$i];

			if($this->defaultImageId != $img->id)
			{

				$obj->url = $img->URL;
				$obj->attribution = $img->attribution;
				$obj->rotation = $img->rotation;
				$imgText = IASImageText::withIASImageAndLanguageId(
					$img->id, $languageId)->first();
				if(null == $imgText)
				{

					$imgText = IASImageText::withIASImageAndLanguageId(
						$img->id, $defaultLanguageId)->first();

				}

				if(null != $imgText)
					$obj->text = $imgText->text;
				else
					$obj->text = "";

				$obj->texts = array();
				for($j=0; $j<count($langs); ++$j)
				{

					$imgText = IASImageText::withIASImageAndLanguageId(
						$img->id, $langs[$j]->id)->first();
					if(null == $imgText)
					{

						$imgText = IASImageText::withIASImageAndLanguageId(
							$img->id, $defaultLanguageId)->first();

					}

					if(null != $imgText)
						$obj->texts[$langs[$j]->locale] = $imgText->text;
					else
						$obj->texts[$langs[$j]->locale] = "";

				}

				$data[] = $obj;

			}

		}

		return $data;

	}

	public function getDescriptionData($languageId, $defaultLanguageId)
	{

		$obj = new stdClass();

		$iasDesc = IASDescription::withIASAndLanguageId(
			$this->id, $languageId)->first();
		if(null == $iasDesc)
		{

			$iasDesc = IASDescription::withIASAndLanguageId(
				$this->id, $defaultLanguageId)->first();

		}
		$obj->name = $iasDesc->name;
		$obj->shortDescription = $iasDesc->shortDescription;
		$obj->sizeLongDescription = $iasDesc->sizeLongDescription;
		$obj->infoLongDescription = $iasDesc->infoLongDescription;
		$obj->habitatLongDescription = $iasDesc->habitatLongDescription;
		$obj->confuseLongDescription = $iasDesc->confuseLongDescription;
		$obj->longDescription = $iasDesc->sizeLongDescription.' '.$iasDesc->infoLongDescription.' '.$iasDesc->habitatLongDescription.' '.$iasDesc->confuseLongDescription;

		return $obj;

	}

	public function getDescriptionsData($defaultLanguageId)
	{

		$langs = Language::all();
		$descs = array();
		for($i=0; $i<count($langs); ++$i)
		{

			$obj = new stdClass();
			$languageId = $langs[$i]->id;

			$iasDesc = IASDescription::withIASAndLanguageId(
				$this->id, $languageId)->first();
			if(null == $iasDesc)
			{

				$iasDesc = IASDescription::withIASAndLanguageId(
					$this->id, $defaultLanguageId)->first();

			}
			$obj->name = $iasDesc->name;
			$obj->shortDescription = $iasDesc->shortDescription;
			$obj->sizeLongDescription = $iasDesc->sizeLongDescription;
			$obj->infoLongDescription = $iasDesc->infoLongDescription;
			$obj->habitatLongDescription = $iasDesc->habitatLongDescription;
			$obj->confuseLongDescription = $iasDesc->confuseLongDescription;
			$obj->longDescription = $iasDesc->sizeLongDescription.' '.$iasDesc->infoLongDescription.' '.$iasDesc->habitatLongDescription.' '.$iasDesc->confuseLongDescription;

			$descs[$langs[$i]->locale] = $obj;

		}

		return $descs;

	}

	public function getTaxons($languageId, $defaultLanguageId)
	{

		$data = array();

		$taxonId = $this->taxonId;

		while(null !== $taxonId)
		{

			$taxon = IASTaxon::find($taxonId);
			$taxonName = IASTaxonName::withIASTaxonAndLanguageId($taxonId, $languageId)->first();
			if(null == $taxonName)
				$taxonName = IASTaxonName::withIASTaxonAndLanguageId($taxonId, $languageId)->first();
			$taxon->name = $taxonName->name;
			$taxonId = $taxon->parentTaxonId;

			$data[] = $taxon;

		}

		return $data;

	}

	public function getRelatedDBs()
	{

		$data = array();
		$related = IASRelatedDB::withIASId($this->id)->get();

		for($i=0; $i<count($related); ++$i)
		{

			$relatedDB = $related[$i];
			$repo = $relatedDB->repository;
			$relatedDB->repoName = $repo->name;
			$relatedDB->repoURL = $repo->URL;
			$relatedDB->repoDesc = $repo->description;
			$data[] = $relatedDB;

		}

		return $data;

	}

	public function scopeWithUserId($query, $userId)
	{

		return $query->join('observations', 'IAS.id', '=', 'observations.IASId')
			->where('observations.userId', '=', $userId)
			->select('IAS.*')->distinct();

	}

	public function scopeLastUpdated($query)
	{

		return $query->orderBy('updated_at', 'DESC');

	}

	public function scopeOrderByTaxon($query)
	{

		return $query->orderBy('taxonId', 'ASC');

	}

	public function scopeOrderByName($query)
	{

		return $query->orderBy('latinName', 'ASC');

	}

	function scopeWithDataTableRequest($query, $search, $orders, $columns)
	{

		return $query->whereRaw('lower("latinName") LIKE lower(\'%'.$search['value'].'%\')')->orderBy($columns[$orders[0]['column']]['data'], $orders[0]['dir']);

	}

}

?>