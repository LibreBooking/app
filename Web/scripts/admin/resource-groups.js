function ResourceGroupManagement(opts)
{
	var options = opts;

	var elements = {
		groupDiv: $('#group-tree'),
		deleteResource: $('.remove-resource'),
		addGroupButton: $('#btnAddGroup'),
		addGroupForm: $('#addGroupForm')
	};

	ResourceGroupManagement.prototype.init = function (groups)
	{
		$(".new-group").watermark(opts.newGroupText);

		$('#group-tree').contextMenu({
					selector: '.ui-droppable',
					callback: function(key, options) {
					            var m = "clicked: " + key;
					            window.console && console.log(m) || alert(m);
					        },
					items: {
						"edit": {name: "Rename", icon: "edit", callback: function (key, options)
						{
							var m = "edit was clicked";
							window.console && console.log(m) || alert(m);
						}},
						"delete": {name: "Delete", icon: "delete", callback: function (key, options)
						{
							var m = "edit was clicked";
							window.console && console.log(m) || alert(m);
						}},
						"addChild": {
							name: "Add Child",
							type: 'text',
							value: "",
							callback: function (key, options)
							{
								var m = "edit was clicked";
								window.console && console.log(m) || alert(m);
							}
						},
						"sep1": "---------",
						"quit": {name: "Quit", icon: "quit"}
					}}
		);

		elements.groupDiv.tree({
			data: groups,
			saveState: false,
			dragAndDrop: true,
			selectable: false,
			autoOpen: true,

			onCreateLi: function (node, $li)
			{
				if (node.type == 'resource')
				{
					$li.addClass('group-resource');
					$li.find('.jqtree-title').after('<div class="remove-resource" node-id="' + node.id + '">&nbsp;</div>');
				}
				else
				{
					$li.find('.jqtree-element').droppable({
						drop: function (event, ui)
						{
							$(this).removeClass("drop-resource");
							addResource(node, ui.draggable);
						},
						over: function (event, ui)
						{
							$(this).addClass("drop-resource");
						},
						out: function (event, ui)
						{
							$(this).removeClass("drop-resource");
						}
					});
				}
			},

			onCanMove: function (node)
			{
				return !node.resource_id
			},

			onCanMoveTo: function (moved_node, target_node, position)
			{
				if (moved_node.resource_id)
				{
					return canAddResource(target_node, moved_node.resource_id);
				}

				return true;
			}
		});

		elements.groupDiv.bind(
				'tree.contextmenu',
				function (event)
				{
					// The clicked node is 'event.node'
					var node = event.node;

//					$(node.element).contextMenu(
//							{
//								selector: 'div',
//								items: {
//									"edit": {name: "Edit", icon: "edit", callback: function(key, options) {
//									                    var m = "edit was clicked";
//									                    window.console && console.log(m) || alert(m);
//									                }},
//									"delete": {name: "Delete", icon: "delete", callback: function(key, options) {
//									                    var m = "edit was clicked";
//									                    window.console && console.log(m) || alert(m);
//									                }}
////									addChild : {
////									                name: "Add Child",
////									                type: 'text',
////									                value: "",
////										callback: function(key, options) {
////										                    var m = "edit was clicked";
////										                    window.console && console.log(m) || alert(m);
////										                }
////									            },
////									"sep1": "---------",
////									"quit": {name: "Quit", icon: "quit"}
//								}});

//					$(node.element).child('div').contextMenu();
				}
		);

		elements.groupDiv.bind(
				'tree.move',
				function (event)
				{
					moveNode(event.move_info.moved_node, event.move_info.target_node, event.move_info.previous_parent, event.move_info.position);
				});

		elements.groupDiv.delegate('.remove-resource', 'click', function (e)
		{
			var nodeId = $(this).attr('node-id');
			var resourceNode = elements.groupDiv.tree('getNodeById', nodeId);
			removeResource(resourceNode);
		});

		$('.resource-draggable').draggable({ revert: true });

		elements.addGroupButton.click(function (e)
		{
			e.preventDefault();
			elements.addGroupForm.submit();
		});

		ConfigureAdminForm(elements.addGroupForm, defaultSubmitCallback(elements.addGroupForm), onGroupAdded, null, {onBeforeSubmit: onBeforeAddGroup});
	};

	function addResource(targetNode, resourceElement)
	{
		var resourceId = resourceElement.attr('resource-id');
		if (canAddResource(targetNode, resourceId))
		{
			PerformAsyncPost(getResourceActionUrl(targetNode.id, resourceId, opts.actions.addResource), {done: function (data)
			{
			}});

			elements.groupDiv.tree(
					'appendNode',
					{
						label: resourceElement.attr('resource-name'),
						id: resourceId,
						resource_id: resourceId,
						type: 'resource'
					},
					targetNode);
		}
	}

	function removeResource(resourceNode)
	{
		var resourceId = resourceNode.resource_id;
		PerformAsyncPost(getResourceActionUrl(resourceNode.group_id, resourceId, opts.actions.removeResource), {done: function (data)
		{
		}});

		elements.groupDiv.tree('removeNode', resourceNode);
	}

	function canAddResource(targetNode, resourceId)
	{
		var canAdd = true;
		$.each(targetNode.children, function (index, value)
		{
			if (value.resource_id && value.resource_id == resourceId)
			{
				canAdd = false;
			}
		});
		return canAdd;
	}

	function onGroupAdded(data)
	{
		var parentNode = null;

		if (data.parent_id && data.parent_id != null && data.parent_id != '')
		{
			parentNode = elements.groupDiv.tree('getNodeById', data.parent_id);
		}
		elements.groupDiv.tree('appendNode', JSON.parse(data), parentNode);
	}

	function onBeforeAddGroup(arr, $form, options)
	{
		var newGroup = $form.find('.new-group').first();
		var groupName = $.trim(newGroup.val());

		if (groupName != '')
		{
			$form.find('.new-group').val('');
			return true;
		}

		return false;
	}

	function getMoveNodeUrl(targetNodeId, movedNodeId, previousId, type, action)
	{
		return options.submitUrl + "?gid=" + targetNodeId + "&nid=" + movedNodeId + "&type=" + type + "&pid=" + previousId + "&action=" + action;
	}

	function moveNode(movedNode, targetNode, previousNode, newPosition)
	{
		var movedId = movedNode.id;
		var targetNodeId = targetNode.id;
		if (movedNode.type == 'resource')
		{
			movedId = movedNode.resource_id;
		}
		if (newPosition == 'before')
		{
			targetNodeId = null;
		}
		if (newPosition == 'after')
		{
			targetNodeId = targetNode.parent.id;
		}
		var previousId = previousNode.id;
		PerformAsyncPost(getMoveNodeUrl(targetNodeId, movedId, previousId, movedNode.type, opts.actions.moveNode), {done: function (data)
		{
		}});
	}

	var getResourceActionUrl = function (targetGroupId, resourceId, action)
	{
		return options.submitUrl + "?gid=" + targetGroupId + "&rid=" + resourceId + "&action=" + action;
	};

	var defaultSubmitCallback = function (form)
	{
		return function ()
		{
			return options.submitUrl + "?action=" + form.attr('ajaxAction');
		};
	};

	var handleAddError = function (result)
	{
	};
}