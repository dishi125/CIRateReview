/*! Image Uploader - v1.2.3 - 26/11/2019
 * Copyright (c) 2019 Christian Bayer; Licensed MIT */

(function ($) {

	$.fn.imageUploader = function (options) {

		// Default settings
		let defaults = {
			preloaded: [],
			imagesInputName: 'images',
			preloadedInputName: 'preloaded',
			label: 'Drag & Drop files here or click to browse',
			extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg'],
			mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
			maxSize: undefined,
			maxFiles: undefined,
		};

		// Get instance
		let plugin = this;

		// Will keep the files
		let dataTransfer = new DataTransfer();

		// The file input
		let $input;

		// Set empty settings
		plugin.settings = {};

		// Plugin constructor
		plugin.init = function () {

			// Define settings
			plugin.settings = $.extend(plugin.settings, defaults, options);

			// Run through the elements
			plugin.each(function (i, wrapper) {

				// Create the container
				let $container = createContainer();

				// Append the container to the wrapper
				$(wrapper).append($container);

				// Set some bindings
				$container.on("dragover", fileDragHover.bind($container));
				$container.on("dragleave", fileDragHover.bind($container));
				$container.on("drop", fileSelectHandler.bind($container));

				// If there are preloaded images
				if (plugin.settings.preloaded.length) {

					// Change style
					$container.addClass('has-files');

					// Get the upload images container
					let $uploadedContainer = $container.find('.uploaded');

					// Set preloaded images preview
					for (let i = 0; i < plugin.settings.preloaded.length; i++) {
						var file_name = plugin.settings.preloaded[i].src.split("/").pop();
						var ext = file_name.split(".").pop();
						var doc_exts = ['pdf', 'html', 'htm', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'rar', 'zip'];
						var audio_exts = ['mp3', 'wav'];
						var video_exts = ['mp4', 'mpeg'];
						if ($.inArray(ext, doc_exts) != -1){
							var src = $("#base_url").val() + "assets/images/doc_image.webp";
						}
						else if ($.inArray(ext, audio_exts) != -1){
							var src = $("#base_url").val() + "assets/images/audio_image.jpg";
						}
						else if ($.inArray(ext, video_exts) != -1){
							var src = $("#base_url").val() + "assets/images/video_image.png";
						}
						else {
							var src = plugin.settings.preloaded[i].src;
						}
						$uploadedContainer.append(createImg(src, plugin.settings.preloaded[i].id, true, file_name));
					}

				}

			});

		};

		let createContainer = function () {

			// Create the image uploader container
			let $container = $('<div>', {class: 'image-uploader'});

			// Create the input type file and append it to the container
			$input = $('<input>', {
				type: 'file',
				id: plugin.settings.imagesInputName + '-' + random(),
				name: plugin.settings.imagesInputName + '[]',
				accept: plugin.settings.extensions.join(','),
				multiple: ''
			}).appendTo($container);

			// Create the uploaded images container and append it to the container
			let $uploadedContainer = $('<div>', {class: 'uploaded'}).appendTo($container),

				// Create the text container and append it to the container
				$textContainer = $('<div>', {
					class: 'upload-text'
				}).appendTo($container),

				// Create the icon and append it to the text container
				$i = $('<i>', {class: 'iui-cloud-upload'}).appendTo($textContainer),

				// Create the text and append it to the text container
				$span = $('<span>', {text: plugin.settings.label}).appendTo($textContainer);


			// Listen to container click and trigger input file click
			$container.on('click', function (e) {
				// Prevent browser default event and stop propagation
				prevent(e);

				// Trigger input click
				$input.trigger('click');
			});

			// Stop propagation on input click
			$input.on("click", function (e) {
				e.stopPropagation();
			});

			// Listen to input files changed
			$input.on('change', fileSelectHandler.bind($container));

			return $container;
		};


		let prevent = function (e) {
			// Prevent browser default event and stop propagation
			e.preventDefault();
			e.stopPropagation();
		};

		let createImg = function (src, id, preloaded, file_name) {

			// Create the upladed image container
			let $container = $('<div>', {class: 'uploaded-image', title: file_name}),

				// Create the img tag
				$img = $('<img>', {src: src}).appendTo($container),

				// Create the delete button
				$button = $('<button>', {class: 'delete-image'}).appendTo($container),
				// Create the delete icon
				$i = $('<i>', {class: 'iui-close'}).appendTo($button);

				// $(`<span><a href="${src}" target="_blank"><i class="ri-eye-fill"></i></a></span>`).appendTo($container);
			// If the image is preloaded
			if (preloaded) {

				// Set a identifier
				$container.attr('data-preloaded', true);

				// Create the preloaded input and append it to the container
				let $preloaded = $('<input>', {
					type: 'hidden',
					name: plugin.settings.preloadedInputName + '[]',
					value: id
				}).appendTo($container)

			} else {

				// Set the index
				$container.attr('data-index', id);

			}

			// Stop propagation on click
			$container.on("click", function (e) {
				// Prevent browser default event and stop propagation
				prevent(e);
			});

			// Set delete action
			$button.on("click", function (e) {

				// Prevent browser default event and stop propagation
				prevent(e);

				// Get the parent element
				let $parent = $container.parent();

				// If is not a preloaded image
				if ($container.data('preloaded') === true) {

					// Remove from preloaded array
					plugin.settings.preloaded = plugin.settings.preloaded.filter(function (p) {
						return p.id !== id;
					});

				} else {

					// Get the image index
					let index = parseInt($container.data('index'));

					// Update other indexes
					$parent.find('.uploaded-image[data-index]').each(function (i, cont) {
						if (i > index) {
							$(cont).attr('data-index', i - 1);
						}
					});

					// Remove the file from input
					dataTransfer.items.remove(index);

					// Update input files
					$input.prop('files', dataTransfer.files);
				}

				// Remove this image from the container
				$container.remove();

				// If there is no more uploaded files
				if (!$parent.children().length) {

					// Remove the 'has-files' class
					$parent.parent().removeClass('has-files');

				}

			});

			return $container;
		};

		let fileDragHover = function (e) {

			// Prevent browser default event and stop propagation
			prevent(e);

			// Change the container style
			if (e.type === "dragover") {
				$(this).addClass('drag-over');
			} else {
				$(this).removeClass('drag-over');
			}
		};

		let fileSelectHandler = function (e) {

			// Prevent browser default event and stop propagation
			prevent(e);

			// Get the jQuery element instance
			let $container = $(this);

			// Get the files as an array of files
			let files = Array.from(e.target.files || e.originalEvent.dataTransfer.files);

			// Will keep only the valid files
			let validFiles = [];

			// Run through the files
			$(files).each(function (i, file) {
				// Run the validations
				if (plugin.settings.extensions && !validateExtension(file)) {
					return;
				}
				if (plugin.settings.mimes && !validateMIME(file)) {
					return;
				}
				if (plugin.settings.maxSize && !validateMaxSize(file)) {
					return;
				}
				if (plugin.settings.maxFiles && !validateMaxFiles(validFiles.length, file)) {
					return;
				}
				validFiles.push(file);
			});

			// If there is at least one valid file
			if (validFiles.length) {
				// Change the container style
				$container.removeClass('drag-over');

				// Makes the upload
				setPreview($container, validFiles);
			} else {

				// Update input files (it is now empty due to a default browser action)
				$input.prop('files', dataTransfer.files);

			}
		};

		let validateExtension = function (file) {

			if (plugin.settings.extensions.indexOf(file.name.replace(new RegExp('^.*\\.'), '.')) < 0) {
				alert(`The file "${file.name}" does not match with the accepted file extensions: "${plugin.settings.extensions.join('", "')}"`);

				return false;
			}

			return true;
		};

		let validateMIME = function (file) {

			if (plugin.settings.mimes.indexOf(file.type) < 0) {
				alert(`The file "${file.name}" does not match with the accepted mime types: "${plugin.settings.mimes.join('", "')}"`);

				return false;
			}

			return true;
		};

		let validateMaxSize = function (file) {

			if (file.size > plugin.settings.maxSize) {
				alert(`The file "${file.name}" exceeds the maximum size of ${plugin.settings.maxSize / 1024 / 1024}Mb`);

				return false;
			}

			return true;

		};

		let validateMaxFiles = function (index, file) {

			if ((index + dataTransfer.items.length + plugin.settings.preloaded.length) >= plugin.settings.maxFiles) {
				alert(`The file "${file.name}" could not be added because the limit of ${plugin.settings.maxFiles} files was reached`);

				return false;
			}

			return true;

		};

		let setPreview = function ($container, files) {

			// Add the 'has-files' class
			$container.addClass('has-files');

			// Get the upload images container
			let $uploadedContainer = $container.find('.uploaded'),

				// Get the files input
				$input = $container.find('input[type="file"]');

			// Run through the files
			$(files).each(function (i, file) {

				// Add it to data transfer
				dataTransfer.items.add(file);

				var doc_mime_types = ['application/pdf','text/html', 'text/plain', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
					'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
					'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
					'application/vnd.rar', 'application/zip'];
				var audio_mime_types = ['audio/mpeg', 'audio/wav'];
				var video_mime_types = ['video/mp4', 'video/mpeg'];

				if ($.inArray(file.type, doc_mime_types) != -1){
					var src = $("#base_url").val() + "assets/images/doc_image.webp";
				}
				else if ($.inArray(file.type, audio_mime_types) != -1){
					var src = $("#base_url").val() + "assets/images/audio_image.jpg";
				}
				else if ($.inArray(file.type, video_mime_types) != -1){
					var src = $("#base_url").val() + "assets/images/video_image.png";
				}
				else {
					var src = URL.createObjectURL(file);
				}
				var file_name = file.name;
				// Set preview
				$uploadedContainer.append(createImg(src, dataTransfer.items.length - 1, false, file_name), false);

			});

			// Update input files
			$input.prop('files', dataTransfer.files);

		};

		// Generate a random id
		let random = function () {
			return Date.now() + Math.floor((Math.random() * 100) + 1);
		};

		this.init();

		// Return the instance
		return this;
	};

}(jQuery));
