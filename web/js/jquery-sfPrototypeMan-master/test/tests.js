/**
 * @param string name
 *
 * @return HTMLElement The plain DOM element - w/o jQuery extension (!)
 */
function getFixture(name) {
	var fixtures = {
		"animals":
			"<div>"+
				"<label>Animals</label>"+
				"<div data-prototype='&lt;div&gt;&lt;label class=&quot;required&quot;&gt;__name__label__&lt;/label&gt;&lt;div id=&quot;MyFormType_animals___name__&quot;&gt;&lt;div&gt;&lt;label for=&quot;MyFormType_animals___name___name&quot; class=&quot;required&quot;&gt;Name&lt;/label&gt;&lt;input type=&quot;text&quot; id=&quot;MyFormType_animals___name___name&quot; name=&quot;MyFormType[animals][__name__][name]&quot; required=&quot;required&quot; /&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;' id='MyFormType_animals'>"+
					"<div>"+
						"<label class='required'>0</label>"+
						"<div id='MyFormType_animals_0'>"+
							"<div>"+
								"<label class='required' for='MyFormType_animals_0_name'>Name</label>"+
								"<input type='text' required='required' name='MyFormType[animals][0][name]' id='MyFormType_animals_0_name' value='Lion'>"+
							"</div>"+
						"</div>"+
					"</div>"+
				"</div>"+
			"</div>",
		"plants":
			"<div>"+
				"<label>Plants</label>"+
				"<div data-prototype='&lt;div&gt;&lt;label class=&quot;required&quot;&gt;__name__label__&lt;/label&gt;&lt;div id=&quot;NotherFormType_plants___name__&quot;&gt;&lt;div&gt;&lt;label for=&quot;NotherFormType_plants___name___name&quot; class=&quot;required&quot;&gt;Name&lt;/label&gt;&lt;input type=&quot;text&quot; id=&quot;NotherFormType_plants___name___name&quot; name=&quot;NotherFormType[plants][__name__][name]&quot; required=&quot;required&quot; /&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;' id='NotherFormType_plants'>"+
					"<div>"+
						"<label class='required'>0</label>"+
						"<div id='NotherFormType_plants_0'>"+
							"<div>"+
								"<label class='required' for='NotherFormType_plants_0_name'>Name</label>"+
								"<input type='text' required='required' name='NotherFormType[plants][0][name]' id='NotherFormType_plants_0_name' value='Daisy'>"+
							"</div>"+
						"</div>"+
					"</div>"+
				"</div>"+
			"</div>"
	};
	fixtures.formAnimals = "<form>" + fixtures.animals + "</form>";
	fixtures.formPlants = "<form>" + fixtures.plants + "</form>";
	fixtures.twoOneForm = "<form>" + fixtures.animals + fixtures.plants + "</form>";
	fixtures.twoTwoForms = "<form>" + fixtures.animals + "</form><form>" + fixtures.plants + "</form>";
	// wrapping fixtures in a joined root element to simulate living in <body>
	return jQuery.parseHTML("<div>" + fixtures[name] + "</div>")[0];
}

function assertType(variable, type, message) {
	return equal(jQuery.type(variable), type, message);
}

module("Plugin");

QUnit.test("plugged in", 1, function () {
	assertType(jQuery.fn.sfPrototypeMan, "function");
});

QUnit.test("default options set", 12, function () {
	var defaultOptions = jQuery.fn.sfPrototypeMan.defaultOptions;
	assertType(defaultOptions, "object");
	assertType(defaultOptions.prototypeDataKey, "string");
	assertType(defaultOptions.containerSelector, "string");
	assertType(defaultOptions.containerClass, "string");
	assertType(defaultOptions.fieldLabelPattern, "regexp");
	assertType(defaultOptions.fieldNamePattern, "regexp");
	assertType(defaultOptions.allInputsSelector, "string");
	assertType(defaultOptions.addButtonMarkup, "string");
	assertType(defaultOptions.addButtonText, "string");
	assertType(defaultOptions.rmButtonMarkup, "string");
	assertType(defaultOptions.rmButtonText, "string");
	assertType(defaultOptions.containerListeners, "object");
});

module("Manager");

QUnit.test("no matches w/o proper dom", 1, function() {
	var man = new jQuery.fn.sfPrototypeMan.classes.SfPrototypeMan(document, jQuery.fn.sfPrototypeMan.defaultOptions);
	equal(man.getContainers().length, 0, "nothing in test (qunit) dom");
});

// @todo fixture of defaultOptions
QUnit.test("getting containers", 6, function() {
	var dom = getFixture("twoOneForm"),
		man = new jQuery.fn.sfPrototypeMan.classes.SfPrototypeMan(dom, jQuery.fn.sfPrototypeMan.defaultOptions),
		containers = man.getContainers();
	assertType(containers, "array");
	equal(containers.length, 2);
	equal(containers[0].getDomElement(), jQuery("form *[data-prototype]", dom)[0]);
	equal(containers[1].getDomElement(), jQuery("form *[data-prototype]", dom)[1]);
	equal(jQuery(containers[0].getDomElement()).attr("id"), "MyFormType_animals");
	equal(jQuery(containers[1].getDomElement()).attr("id"), "NotherFormType_plants");
});

module("Container");

QUnit.test("container extension (kinda integration test)", 4, function() {
	var dom = getFixture("formAnimals"),
		containerDom = jQuery("*[data-prototype]", dom),
		container = new jQuery.fn.sfPrototypeMan.classes.SfPrototypeContainer(containerDom, jQuery.fn.sfPrototypeMan.defaultOptions);
	equal(jQuery(container.getDomElement()).hasClass("sfPrototypeMan"), false);
	equal(jQuery._data(container.getDomElement(), "events"), undefined);
	container._extendContainer();
	equal(jQuery(container.getDomElement()).hasClass("sfPrototypeMan"), true);
	var callbacks = jQuery._data(container.getDomElement(), "events");
	equal(callbacks.sortupdate[0].origType, "sortupdate");
	// @todo check addButton added
});

QUnit.test("get container content (existing 'fields')", 1, function() {
	var dom = getFixture("formAnimals"),
		containerDom = jQuery("*[data-prototype]", dom),
		container = new jQuery.fn.sfPrototypeMan.classes.SfPrototypeContainer(containerDom, jQuery.fn.sfPrototypeMan.defaultOptions),
		children = jQuery(container.getDomElement()).children();
	deepEqual(container._getExisting().toArray(), children.toArray());
});

QUnit.test("rm button added", 6, function() {
	var dom = getFixture("formAnimals"),
		containerDom = jQuery("*[data-prototype]", dom),
		container = new jQuery.fn.sfPrototypeMan.classes.SfPrototypeContainer(containerDom, jQuery.fn.sfPrototypeMan.defaultOptions),
		children = container._getExisting();

	equal(children.length, 1);

	equal(jQuery("> a.rmElement", children[0]).length, 0, "at first there is no button");
	container._extendFields();
	var rmButtons = jQuery("> a.rmElement", children[0]);
	equal(rmButtons.length, 1, "exactly one button was added");
	equal(jQuery._data(rmButtons[0], "events")["click"].length, 1);

	jQuery(container._container).on("prototype.elementremoved", function(event, cont) {
		equal(cont, container, "container passed to rm callback & called");
	});

	jQuery(rmButtons[0]).trigger("click");

	equal(container._getExisting().length, 0, "number of fields decreased");
});

/**
 * @tutorial Has a 0 _local_ 'expected' count, sub-methods increment for themselves
 */
QUnit.test("reindexing after rm (very much integration)", 0, function() {
	var dom = getFixture("formPlants"),
	containerDom = jQuery("*[data-prototype]", dom),
	container = new jQuery.fn.sfPrototypeMan.classes.SfPrototypeContainer(containerDom, jQuery.fn.sfPrototypeMan.defaultOptions),
	testnames = {
		// 0: "Daisy",	// already in dom from fixture
		1: "Sunflower",
		2: "Strawberry",
		3: "Barley",
		4: "Pine"
	},
	//replacement result (tested here) as per both options and fixture prototype
	assertStruct = function (field, position, value) {
		QUnit.config.current.expected += 5;	// 5 assertions in here
		equal(jQuery("> label", field).html(), position, "form label");
		equal(jQuery("> div", field).attr("id"), "NotherFormType_plants_" + position);
		var input = jQuery(jQuery(":input", field)[0]);
		equal(input.attr("id"), "NotherFormType_plants_" + position + "_name", "input id");
		equal(input.attr("name"), "NotherFormType[plants][" + position + "][name]", "input name");
		equal(input.val(), value, "input value");
	},
	expectFieldVals = function(expected) {
		QUnit.config.current.expected += 1;	// 1 assertion in here
		var fieldDomElements = container._getExisting();
		equal(fieldDomElements.length, expected.length, "no more fields than expected");
		jQuery.each(expected, function(pos, name) {
			assertStruct(fieldDomElements[pos], pos, name);
		});
	},
	rmFieldByPos = function(pos) {
		jQuery('a.rmElement', container._getExisting()[pos]).trigger("click");
	};

	expectFieldVals(["Daisy"]);

	// more fields
	container.addField(); container.addField(); container.addField(); container.addField();
	// adding some values as it's the only information not to be changed by code
	jQuery.each(container._getExisting(), function(i, ele) {
		if (testnames[i]) {
			jQuery(jQuery(":input", ele)[0]).val(testnames[i]);
		}
	});

	expectFieldVals(["Daisy", "Sunflower", "Strawberry", "Barley", "Pine"]);
	rmFieldByPos(2);
	expectFieldVals(["Daisy", "Sunflower", "Barley", "Pine"]);
	rmFieldByPos(3);
	expectFieldVals(["Daisy", "Sunflower", "Barley"]);
	rmFieldByPos(0);
	expectFieldVals(["Sunflower", "Barley"]);
	container.addField();
	expectFieldVals(["Sunflower", "Barley", ""]);
	rmFieldByPos(0);
	expectFieldVals(["Barley", ""]);
	rmFieldByPos(1);
	expectFieldVals(["Barley"]);
	rmFieldByPos(0);
	expectFieldVals([]);
	container.addField();
	expectFieldVals([""]);
});

// @todo test _getFieldHtml
// @todo test _createField

QUnit.test("add button added", 7, function() {
	var dom = getFixture("formAnimals"),
		containerDom = jQuery("*[data-prototype]", dom),
		container = new jQuery.fn.sfPrototypeMan.classes.SfPrototypeContainer(containerDom, jQuery.fn.sfPrototypeMan.defaultOptions);

	equal(container._getExisting().length, 1);

	equal(jQuery("#MyFormType_animals + a.addPrototype", dom).length, 0);
	var button = container._addAddButton();
	var addButtons = jQuery("#MyFormType_animals + a.addPrototype", dom);
	equal(addButtons.length, 1, "button added");
	equal(button, addButtons[0], "where we expect it (next to [+] the container)");

	var callbacks = jQuery._data(button, "events")["click"];
	equal(callbacks.length, 1);

	jQuery(container._container).on("prototype.added", function(event, cont) {
		equal(cont, container);
	});

	jQuery(button).trigger("click");

	equal(container._getExisting().length, 2, "number of fields increased");
});

QUnit.test("listeners attached to container", 1, function() {
	var dom = getFixture("formAnimals"),
		containerDom = jQuery("*[data-prototype]", dom),
		options = jQuery.fn.sfPrototypeMan.defaultOptions;

	options.containerListeners["loremipsum"] = function() {
		equal(this, container);
	};

	var container = new jQuery.fn.sfPrototypeMan.classes.SfPrototypeContainer(containerDom, options);
	container._extendContainer();

	jQuery(container._container).trigger("loremipsum");
});
