<template>
<div>
    <div class="progress">
        <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100" :style="{ width: progress + '%' }">
            {{ progress }}%
        </div>
    </div>

    <label class="btn btn-default">
        <input type="file" ref="file" @change="selectFile" :disabled="state != 0" />
    </label>
    <label v-show="state == 1" style=" font-size: 1.3em; color: #181b8c;"> Loading ... </label>
    <button class="btn btn-success" :hidden="state != 2" @click="upload">
        Upload
    </button>
</div>
</template>

<script>
import UploadService from "../UploadFilesService";

export default {
    name: "upload-files",
    data() {
        return {
            state: 0, // 0: ready, 1: converting, 2: converted, 3: uploading, 4:finished
            progress: 0,
            parser_array: [],
            per_count: 1000,
            start: 0,
            end: 0,
        };
    },
    methods: {
        selectFile() {
            var currentFile = this.$refs.file.files[0];
            if (!currentFile) return;
            var reader = new FileReader();
            var self = this;
            self.state = 1;
            reader.onload = function (e) {
                var readXml = e.target.result;
                var parser = new DOMParser();
                var xml = parser.parseFromString(readXml, "application/xml");
                self.parser_array = parse(xml);
                self.state = 2;
            };
            reader.readAsText(currentFile);
        },
        upload() {
            this.progress = 0;
            this.state = 3;
            var self = this;
            var count = Math.ceil(self.parser_array.length / self.per_count);
            var i = 0;
            while (self.end <= self.parser_array.length) {
                // while (self.end <= 100) {
                self.end += self.per_count;
                UploadService.upload(
                    self.parser_array.slice(self.start, self.end),
                    (event) => {
                        self.progress = self.progress + Math.round((100 * event.loaded) / event.total) / count;
                    },
                    "/api/xml_upload"
                ).then((response) => {
                    i++;
                    if (i == count) {
                        self.progress = 0;
                        self.state = 0;
                        self.start = 0;
                        self.end = 0;
                        self.$refs.file.value = null;
                        alert("File uploading finished");
                    }
                });
                self.start = self.end;

            }
        },

    },
    mounted() {},
};

function flatten(object) {
    var check = _.isPlainObject(object) && _.size(object) === 1;
    return check ? flatten(_.values(object)[0]) : object;
}

function parse(xml) {
    var data = {};

    var isText = xml.nodeType === 3,
        isElement = xml.nodeType === 1,
        body = xml.textContent && xml.textContent.trim(),
        hasChildren = xml.children && xml.children.length,
        hasAttributes = xml.attributes && xml.attributes.length;

    // if it's text just return it
    if (isText) {
        return xml.nodeValue.trim();
    }

    // if it doesn't have any children or attributes, just return the contents
    if (!hasChildren && !hasAttributes) {
        return body;
    }

    // if it doesn't have children but _does_ have body content, we'll use that
    if (!hasChildren && body.length) {
        data.text = body;
    }

    // if it's an element with attributes, add them to data.attributes
    if (isElement && hasAttributes) {
        data.attributes = _.reduce(
            xml.attributes,
            function (obj, name, id) {
                var attr = xml.attributes.item(id);
                obj[attr.name] = attr.value;
                return obj;
            }, {}
        );
    }

    // recursively call #parse over children, adding results to data
    _.each(xml.children, function (child) {
        var name = child.nodeName;

        // if we've not come across a child with this nodeType, add it as an object
        // and return here
        if (!_.has(data, name)) {
            data[name] = parse(child);
            return;
        }

        // if we've encountered a second instance of the same nodeType, make our
        // representation of it an array
        if (!_.isArray(data[name])) {
            data[name] = [data[name]];
        }

        // and finally, append the new child
        data[name].push(parse(child));
    });

    // if we can, let's fold some attributes into the body
    _.each(data.attributes, function (value, key) {
        if (data[key] != null) {
            return;
        }
        data[key] = value;
        delete data.attributes[key];
    });

    // if data.attributes is now empty, get rid of it
    if (_.isEmpty(data.attributes)) {
        delete data.attributes;
    }

    // simplify to reduce number of final leaf nodes and return
    return flatten(data);
}
</script>
