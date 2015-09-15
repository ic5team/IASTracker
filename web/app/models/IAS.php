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

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('creatorId', 'created_at', 'updated_at');

	public function getDefaultImageData($languageId, $defaultLanguageId)
	{

		$obj = new stdClass();

		if(null != $this->defaultImageId)
		{

			$img = IASImage::find($this->defaultImageId);
			$obj->url = $img->URL;
			$obj->attribution = $img->attribution;
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

		}

		return $obj;

	}

	public function getImageData($languageId, $defaultLanguageId)
	{

		$data = array();
		$images = IASImage::withIASId($this->id)->get();

		for($i=0; $i<count($images); ++$i)
		{

			$obj = new stdClass();
			$img = $images[$i];
			$obj->url = $img->URL;
			$obj->attribution = $img->attribution;
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

			$data[] = $obj;

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
		$obj->longDescription = $iasDesc->longDescription;

		return $obj;

	}

	public function getTaxons()
	{

		$data = array();

		$taxonId = $this->taxonId;

		while(null != $taxonId)
		{

			$taxon = IASTaxon::find($taxonId);
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
			$data[] = $relatedDB;

		}

		return $data;

	}

	function scopeWithUserId($query, $userId)
	{

		return $query->join('observations', 'IAS.id', '=', 'observations.IASId')
			->where('observations.userId', '=', $userId)
			->select('IAS.*');

	}

}

?>