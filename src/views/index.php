<div class="font-sans leading-tight min-h-screen bg-grey-lighter stick-form">
    <div class="flex flex-row title mb-3">
        <h1 style="font-size: 25px;padding-top: 3px;margin-left: 5px;">Jenkins Log</h1>
    </div>
    <form method="post" id="form">
    <div class="max-w-sm mx-auto bg-white rounded-lg overflow-hidden shadow-lg w-80 p-5 flex flex-col">
        <div class="col-span-6 sm:col-span-3 mb-5">
            <select id="web_app" name="web_app" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option selected disabled>Select Web App</option>
                <!-- generate by js  -->  
            </select>
        </div>
        <div class="col-span-6 sm:col-span-3">
            <select id="branch" name="branch" class="disabled mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option selected disabled>Select Branch</option>
                <!-- generate by js  -->
            </select>
        </div>
    </div>
        <button type="submit" class="hidden">Submit</button>
    </form>
</div>
<div class="wrapper-output">

    <div class="mb-2">
        
        <div class="flex" style="justify-content:space-between">
            <div class="flex">
                <div class="bg-green-100 border border-green-400 p-2 relative rounded text-green-700 message hidden" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">Please wait notification from "CI/CD Deployment" channel</span>
                </div>
            </div>
            <div class="items-end">
                <button class="primary px-2 hidden" id="redeploy" type="button">
                Redeploy</button>
            </div>
        </div>
    </div>
    <!-- console output -->
    <div class="flex items-center output justify-center flex-col flex-grow bg-white shadow overflow-hidden sm:rounded-lg">
        <pre class="hidden pt-2 relative">
        <span class="console-title">&gt; Console Output</span>
        </pre>

        <!-- empty section -->
        <div class="empty hidden flex items-center justify-center flex-col">
            <img src="https://gw.alipayobjects.com/zos/antfincdn/ZHrcdLPrvN/empty.svg" />
            <span>No data</span>
        </div>

        <!-- spinner -->
        <svg id="spinner" class="animate-spin -ml-1 mr-3 h-10 w-10 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
</div>