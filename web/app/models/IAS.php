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

	public function getImageData($languageId, $defaultLanguageId)
	{

		$obj = new stdClass();

		if(null != $this->portraitImageId)
		{

			$img = IASImage::find($this->portraitImageId);
			$obj->image = $img->URL;
			$obj->imageAttribution = $img->attribution;
			$imgText = IASImageText::withIASAndLanguageId(
				$this->id, $languageId)->first();
			if(null == $imgText)
			{

				$imgText = IASImageText::withIASAndLanguageId(
					$this->id, $defaultLanguageId)->first();

			}
			
			$obj->imageText = $imgText->text;

		}

		return $obj;

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

}

?>