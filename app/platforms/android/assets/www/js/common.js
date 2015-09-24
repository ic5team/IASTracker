/*!
	Checks if a value is a valid email
	@param[in] value The value to check
	@return A bool telling us if the value is a correct email or not
*/
function isValidEmail(value)
{

	var ok = false;
 
	if('' != value)
	{
	
		var re = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/;
		ok = re.test(value.toUpperCase());
 
	}
 
	return ok;

}

/*!
	Checks if a value is a valid password. A valid password is one with a length 
	greater than or equal to 8 characters containing lower and upper 
	case letters and a number and that doesn't contain blank spaces and without 
	accents
	@param[in] value The value to check
	@return A bool telling us if the value is a correct password or not
*/
function isValidPassword(value)
{

	var ok = false;
 
	if('' != value)
	{
	
		var re = /^(?=.*[a-zA-Z])(?=.*\d)[^ ]{8,}$/;
		ok = re.test(value);
 
	}
 
	return ok;

}

function isConnected()
{

	return (navigator.connection.type != Connection.NONE);

}

function downloadFile(URL, Folder_Name, File_Name, callback) 
{

	var networkState = navigator.connection.type;
	if (isConnected()) 
	{

		download(URL, Folder_Name, File_Name, callback); 

	}

}

function getFilePath()
{

	//step to request a file system 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, fileSystemSuccess, fileSystemFail);

	function fileSystemSuccess(fileSystem) 
	{

		var rootdir = fileSystem.root;
		var fp = rootdir.toURL();

	}

	function fileSystemFail(evt) {

		console.log("Unable to access file system: " + evt.target.error.code);

	}

}

function download(URL, Folder_Name, File_Name, callback) 
{

	//step to request a file system 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, fileSystemSuccess, fileSystemFail);

	function fileSystemSuccess(fileSystem) 
	{

		var download_link = encodeURI(URL);
		ext = download_link.substr(download_link.lastIndexOf('.') + 1);

		var directoryEntry = fileSystem.root;
		directoryEntry.getDirectory(Folder_Name, { create: true, exclusive: false }, onDirectorySuccess, onDirectoryFail);
		var rootdir = fileSystem.root;
		var fp = rootdir.toURL();

		window.localStorage.setItem('path', fp);

		fp = fp + "/" + Folder_Name + "/" + File_Name + "." + ext.toLowerCase();
		filetransfer(download_link, fp, callback);

	}

	function onDirectorySuccess(parent) {
	}

	function onDirectoryFail(error) {
		
		console.log("Unable to create new directory: " + error.code);

	}

	function fileSystemFail(evt) {

		console.log("Unable to access file system: " + evt.target.error.code);

	}
}

function filetransfer(download_link, fp, callback) 
{

	var fileTransfer = new FileTransfer();
	fileTransfer.download(download_link, fp,
		function (entry) {
			console.log("download complete: " + fp);
			callback();
		},
		function (error) {
			console.log("download error source " + error.source);
		}
	);
}