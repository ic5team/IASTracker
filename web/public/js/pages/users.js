$(document).ready(function() {

	$('.UserExpertCheck').bootstrapSwitch({size: 'mini'});
	var dt = $('#dataContainer').DataTable({
		serverSide: true,
		ajax: function (data, callback, settings) {

			api.getUsers(data, callback);

		},
		columns: [
			{
                class:          "details-control",
                orderable:      false,
                data:           null,
                defaultContent: ""
            },
            { 
            	data: 'id',
            	visible: false
        	},
			{ data: 'fullName' },
			{ 	data: 'isExpert',
				orderable: false,
				render: function ( data, type, row ) {
                    return '<input type="checkbox" class="cbExpert" data-id="' + row.id + '" ' + (row.isExpert ? 'checked' : '') + '>';
                }
			},
			{ 	data: 'isValidator',
				orderable: false,
				render: function ( data, type, row ) {
                    return '<input type="checkbox" class="cbValidator" data-id="' + row.id + '" ' + (row.isValidator ? 'checked' : '') + '>';
                } },
			{ 	data: 'isAdmin',
				orderable: false,
				render: function ( data, type, row ) {
                    return '<input type="checkbox" class="cbAdmin" data-id="' + row.id + '" ' + (row.isAdmin ? 'checked' : '') + '>';
                } 
            },
			{ 	data: 'organization',
				orderable: false,
				render: function ( data, type, row ) {
                    return '<input type="text" class="input-organization" data-id="' + row.id + '" ' + (row.isValidator ? '' : 'disabled') + ' value="' + 
                    	(row.hasOwnProperty('organization') ? row.organization : '') + '">';
                } 
            },
			{ data: 'created_at'},
			{ 
				data: null, 
				orderable: false,
				render: function ( data, type, row ) {
					var saveBtn = '<button type="button" class="btn btn-primary saveBtn" data-id="' + row.id + '"><i class="fa fa-floppy-o"></i></button>';
					var deleteBtn = '<button type="button" class="btn btn-danger delBtn" data-id="' + row.id + '"><i class="fa fa-trash-o"></i></button>';
					var loading = '<img src="' + urlImg + '/loader.gif" class="loading" data-id=' + row.id + ' style="display:none;"/>';
                    return (null == row.deleted_at) ? '<div class="btns" data-id="' + row.id + '" style="width:80px;">' + saveBtn+deleteBtn + '</div>' + loading : 'Deleted';
                } 
            }
		],
		order: [[1, 'asc']]
	});

	// Array to track the ids of the details displayed rows
    var detailRows = [];
 
    $('#dataContainer tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = dt.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
 
        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();
 
            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( childRow( row.data() ) ).show();
 
            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
 
    // On each draw, loop over the `detailRows` array and show any child rows
    dt.on( 'draw', function () 
    {

        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );

        //Event handlers
        $('.cbValidator').off('click');
		$('.cbValidator').on('click', function(e) {
			var id = $(this).attr('data-id');
			if($(this).is(':checked'))
			{


				$('.input-organization[data-id="' + id + '"]').removeAttr('disabled');

			}
			else
			{

				$('.input-organization[data-id="' + id + '"]').attr('disabled', 'disabled');

			}
		});

		$('.saveBtn').off('click');
		$('.saveBtn').on('click', saveUser);

		$('.delBtn').off('click');
		$('.delBtn').on('click', deleteUser);

    });

});

function childRow( d ) {
    return '<div style="display: inline-block;"><img src="' + d.photoURL +'" style="width:150px;"></div>' + 
    	'<div style="display: inline-block; margin-left:15px;"><b>' + d.username + '</b><br>' + d.observationNumber + ' observations | ' + d.validatedNumber + ' validated<br>' + 
    	'Last connected: ' + d.lastConnection + '</div>';
}

function saveUser()
{

	var id = parseInt($(this).attr('data-id'));
	var isExpert = $('.cbExpert[data-id="' + id + '"]').is(':checked');
	var isAdmin = $('.cbAdmin[data-id="' + id + '"]').is(':checked');
	var isValidator = $('.cbValidator[data-id="' + id + '"]').is(':checked');
	var userOrganization = $('.input-organization[data-id="' + id + '"]').val();

	$('.btns[data-id="' + id + '"]').hide();
	$('.loading[data-id="' + id + '"]').show();
	api.addUserData(id, {expert: isExpert, admin: isAdmin, validator: isValidator, organization: userOrganization}, userUpdated);

}

function deleteUser()
{

	var id = parseInt($(this).attr('data-id'));
	$('.btns[data-id="' + id + '"]').hide();
	$('.loading[data-id="' + id + '"]').show();
	api.deleteUser(id, userDeleted);

}

function userUpdated(data)
{

	$('.loading:visible').hide();
	$('.btns:hidden').show();

}

function userDeleted(data)
{

	$('.loading:visible').hide();
	$('.btns:hidden').html('Deleted');
	$('.btns:hidden').show();

}