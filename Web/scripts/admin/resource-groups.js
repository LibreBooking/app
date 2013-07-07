function ResourceGroupManagement(opts)
{
	var options = opts;

	var elements = {
		groupDiv: $('#group-tree'),
		deleteResource: $('.remove-resource')
	};

	ResourceGroupManagement.prototype.init = function (groups)
	{
//		$(".days").watermark('days');
//		$(".hours").watermark('hrs');
//		$(".minutes").watermark('mins');


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
					$li.find('.jqtree-title').after('<div class="remove-resource" node-id="' + node.id +'">&nbsp;</div>');
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
				}
		);

		elements.groupDiv.bind(
				'tree.move',
				function (event)
				{
					console.log('moved_node', event.move_info.moved_node);
					console.log('target_node', event.move_info.target_node);
					console.log('position', event.move_info.position);
					console.log('previous_parent', event.move_info.previous_parent);
				});

		elements.groupDiv.delegate('.remove-resource', 'click', function (e)
		{
			var nodeId = $(this).attr('node-id');
			var resourceNode = elements.groupDiv.tree('getNodeById', nodeId);
			removeResource(resourceNode);
		});

		$('.resource-draggable').draggable({ revert: true });

	};

	function addResource(targetNode, resourceElement)
	{
		var resourceId = resourceElement.attr('resource-id');
		if (canAddResource(targetNode, resourceId))
		{
			PerformAsyncPost(getResourceActionUrl(targetNode.id, resourceId, opts.actions.addResource), {done:function(data){}});

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
		PerformAsyncPost(getResourceActionUrl(resourceNode.group_id, resourceId, opts.actions.removeResource), {done:function(data){}});

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

	var getResourceActionUrl = function (targetGroupId, resourceId, action)
	{
		return options.submitUrl + "?gid=" + targetGroupId + "&rid=" +resourceId + "&action=" + action;
	};

	var handleAddError = function (result)
	{
	};
}