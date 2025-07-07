@props(['name', 'value' => ''])

<div x-data="textEditor('{{ $value }}')" class="w-full __editor__">
    <!-- Toolbar -->
    <div
        class="flex items-center gap-2 bg-gray-100 border border-gray-300 rounded-t-md px-2 py-1"
    >
        <button
            @click="formatText('bold')"
            :class="activeCommands.bold ? 'bg-blue-200 text-blue-700' : 'hover:bg-gray-200'"
            class="p-2 rounded text-lg"
            type="button"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-5"
            >
                <path
                    stroke-linejoin="round"
                    d="M6.75 3.744h-.753v8.25h7.125a4.125 4.125 0 0 0 0-8.25H6.75Zm0 0v.38m0 16.122h6.747a4.5 4.5 0 0 0 0-9.001h-7.5v9h.753Zm0 0v-.37m0-15.751h6a3.75 3.75 0 1 1 0 7.5h-6m0-7.5v7.5m0 0v8.25m0-8.25h6.375a4.125 4.125 0 0 1 0 8.25H6.75m.747-15.38h4.875a3.375 3.375 0 0 1 0 6.75H7.497v-6.75Zm0 7.5h5.25a3.75 3.75 0 0 1 0 7.5h-5.25v-7.5Z"
                />
            </svg>
        </button>
        <button
            @click="formatText('italic')"
            :class="activeCommands.italic ? 'bg-blue-200 text-blue-700' : 'hover:bg-gray-200'"
            class="p-2 rounded"
            type="button"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5.248 20.246H9.05m0 0h3.696m-3.696 0 5.893-16.502m0 0h-3.697m3.697 0h3.803"
                />
            </svg>
        </button>
        <button
            @click="formatText('underline')"
            :class="activeCommands.underline ? 'bg-blue-200 text-blue-700' : 'hover:bg-gray-200'"
            class="p-2 rounded"
            type="button"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M17.995 3.744v7.5a6 6 0 1 1-12 0v-7.5m-2.25 16.502h16.5"
                />
            </svg>
        </button>
        <button
            @click="formatText('insertUnorderedList')"
            :class="activeCommands.insertUnorderedList ? 'bg-blue-200 text-blue-700' : 'hover:bg-gray-200'"
            class="p-2 rounded"
            type="button"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"
                />
            </svg>
        </button>
        <button
            @click="formatText('insertOrderedList')"
            :class="activeCommands.insertOrderedList ? 'bg-blue-200 text-blue-700' : 'hover:bg-gray-200'"
            class="p-2 rounded"
            type="button"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8.242 5.992h12m-12 6.003H20.24m-12 5.999h12M4.117 7.495v-3.75H2.99m1.125 3.75H2.99m1.125 0H5.24m-1.92 2.577a1.125 1.125 0 1 1 1.591 1.59l-1.83 1.83h2.16M2.99 15.745h1.125a1.125 1.125 0 0 1 0 2.25H3.74m0-.002h.375a1.125 1.125 0 0 1 0 2.25H2.99"
                />
            </svg>
        </button>
        <button
            @click="addLink"
            class="p-2 rounded hover:bg-gray-200"
            :class="activeCommands.createLink ? 'bg-blue-200 text-blue-700' : ''"
            type="button"
            title="Insert Link"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"
                />
            </svg>
        </button>
    </div>

    <!-- Contenteditable Area -->
    <div
        x-ref="editor"
        @input="updateInput()"
        contenteditable="true"
        class="border border-gray-300 p-4 rounded-b-md min-h-[240px] max-h-[70vh] overflow-y-auto"
    ></div>

    <!-- Hidden Input -->
    <input type="hidden" name="{{ $name }}" :value="content" />
</div>

<script>
    function textEditor(initialValue) {
        return {
            content: initialValue || "",
            activeCommands: {
                bold: false,
                italic: false,
                underline: false,
                insertUnorderedList: false,
                insertOrderedList: false,
            },
            formatText(command, value = null) {
                document.execCommand(command, false, value);
                this.updateActiveCommands();
            },
            addLink() {
                let href = "";

                const selection = window.getSelection();

                if (selection.rangeCount > 0) {
                    let node = selection.anchorNode;
                    while (node && node.nodeType === 3) {
                        node = node.parentNode;
                    }
                    if (node && node.nodeName === "A") {
                        href = node.getAttribute("href");
                    }
                }

                const url = prompt("Enter the URL:", href);

                if (url === null) {
                    return;
                }

                if (url && this.getSelectedText()) {
                    this.formatText("createLink", url);
                } else if (url) {
                    this.$refs.editor.focus();
                    this.formatText(
                        "insertHTML",
                        `<a href="${url}" target="_blank">${url}</a>`
                    );
                } else {
                    this.$refs.editor.focus();
                    this.formatText("unlink");
                }
            },
            getSelectedText() {
                let text = "";
                if (window.getSelection) {
                    text = window.getSelection().toString();
                }
                return text;
            },
            sanitizeContent(html) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, "text/html");

                doc.querySelectorAll("[style]").forEach((element) => {
                    element.removeAttribute("style");
                });

                return doc.body.innerHTML;
            },
            updateInput() {
                this.content = this.sanitizeContent(
                    this.$refs.editor.innerHTML
                );
            },
            updateActiveCommands() {
                this.activeCommands = {
                    bold: document.queryCommandState("bold"),
                    italic: document.queryCommandState("italic"),
                    underline: document.queryCommandState("underline"),
                    insertUnorderedList: document.queryCommandState(
                        "insertUnorderedList"
                    ),
                    insertOrderedList:
                        document.queryCommandState("insertOrderedList"),
                    createLink: document.queryCommandState("createLink"),
                };
            },
            init() {
                this.$refs.editor.innerHTML = this.content;
                this.updateActiveCommands();
                document.addEventListener("selectionchange", () => {
                    this.updateActiveCommands();
                });
            },
        };
    }
</script>

<style>
    .__editor__ ul {
        list-style-type: disc;
        padding-left: 1.5em;
    }

    .__editor__ ul li::marker {
        font-size: 1.2em;
    }

    .__editor__ ol {
        list-style-type: number;
        padding-left: 1.5em;
    }

    .__editor__ ol li::marker {
        font-size: 1em;
        font-weight: bold;
    }

    .__editor__ a {
        color: #1d4ed8; /* Tailwind's blue-600 */
        text-decoration: underline;
    }
</style>
