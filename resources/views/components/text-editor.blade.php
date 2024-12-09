@props(['name', 'value' => ''])

<div x-data="textEditor('{{ $value }}')" class="w-full __editor__">
    <!-- Toolbar -->
    <div class="flex items-center gap-2 bg-gray-100 border border-gray-300 rounded-t-md px-2 py-1">
        <button @click="formatText('bold')" :class="activeCommands.bold ? 'bg-blue-200 text-blue-700' : 'hover:bg-gray-200'" class="p-2 rounded" type="button">
            <b>B</b>
        </button>
        <button @click="formatText('italic')" :class="activeCommands.italic ? 'bg-blue-200 text-blue-700' : 'hover:bg-gray-200'" class="p-2 rounded" type="button">
            <i>I</i>
        </button>
        <button @click="formatText('underline')" :class="activeCommands.underline ? 'bg-blue-200 text-blue-700' : 'hover:bg-gray-200'" class="p-2 rounded" type="button">
            <u>U</u>
        </button>
        <button @click="formatText('insertUnorderedList')" :class="activeCommands.insertUnorderedList ? 'bg-blue-200 text-blue-700' : 'hover:bg-gray-200'" class="p-2 rounded" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
        </button>
        <button @click="formatText('insertOrderedList')" :class="activeCommands.insertOrderedList ? 'bg-blue-200 text-blue-700' : 'hover:bg-gray-200'" class="p-2 rounded" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.242 5.992h12m-12 6.003H20.24m-12 5.999h12M4.117 7.495v-3.75H2.99m1.125 3.75H2.99m1.125 0H5.24m-1.92 2.577a1.125 1.125 0 1 1 1.591 1.59l-1.83 1.83h2.16M2.99 15.745h1.125a1.125 1.125 0 0 1 0 2.25H3.74m0-.002h.375a1.125 1.125 0 0 1 0 2.25H2.99" />
            </svg>
        </button>
    </div>

    <!-- Contenteditable Area -->
    <div x-ref="editor" @input="updateInput()" contenteditable="true" class="border border-gray-300 p-4 rounded-b-md min-h-[240px]"></div>

    <!-- Hidden Input -->
    <input type="hidden" name="{{ $name }}" :value="content">
</div>

<script>
    function textEditor(initialValue) {
        return {
            content: initialValue || ''
            , activeCommands: {
                bold: false
                , italic: false
                , underline: false
                , insertUnorderedList: false
                , insertOrderedList: false
            , }
            , formatText(command, value = null) {
                document.execCommand(command, false, value);
                this.updateActiveCommands();
            }
            , sanitizeContent(html) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                doc.querySelectorAll('[style]').forEach((element) => {
                    element.removeAttribute('style');
                });

                return doc.body.innerHTML;
            }
            , updateInput() {
                this.content = this.sanitizeContent(this.$refs.editor.innerHTML);
            }
            , updateActiveCommands() {
                this.activeCommands = {
                    bold: document.queryCommandState('bold')
                    , italic: document.queryCommandState('italic')
                    , underline: document.queryCommandState('underline')
                    , insertUnorderedList: document.queryCommandState('insertUnorderedList')
                    , insertOrderedList: document.queryCommandState('insertOrderedList')
                , };
            }
            , init() {
                this.$refs.editor.innerHTML = this.content;
                this.updateActiveCommands();
                document.addEventListener('selectionchange', () => {
                    this.updateActiveCommands();
                });
            }
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
</style>

