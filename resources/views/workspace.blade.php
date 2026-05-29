@extends('layouts.editorial')

@section('content')
<div class="flex-grow flex flex-col h-[calc(100vh-64px)] overflow-hidden bg-[#f4f3ef] text-black">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Workspace Header -->
    <header class="border-b-2 border-black bg-white flex justify-between items-center p-3 brutal-shadow-sm z-10">
        <div class="flex items-center space-x-4 pl-2">
            <div class="bg-yellow-300 border-2 border-black font-mono text-xs px-2 py-1 font-bold uppercase brutal-shadow-xs">Live</div>
            <h1 class="font-bold uppercase text-lg tracking-wider font-mono">Collaborative Whiteboard</h1>
        </div>
        <div class="flex items-center space-x-4 pr-2">
            <!-- Active Users Count & Avatars -->
            <div class="flex items-center space-x-2">
                <span class="text-xs font-mono uppercase font-bold text-gray-600">Online:</span>
                <div id="active-avatars-container" class="flex -space-x-2">
                    <!-- Current User -->
                    <div class="w-8 h-8 rounded-full border-2 border-black flex items-center justify-center text-white font-mono text-xs font-bold z-30" style="background-color: {{ $userColor }};" title="{{ $user->name }} (You)">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>
            </div>
            
            <button id="btn-share" class="brutal-border bg-black text-white px-4 py-1.5 font-mono text-xs font-bold uppercase hover:bg-gray-800 transition-colors brutal-shadow-xs">Share Board</button>
        </div>
    </header>

    <!-- Main Workspace Area -->
    <div class="flex-grow flex flex-col md:flex-row overflow-hidden relative">
        
        <!-- Whiteboard Canvas Container -->
        <div class="flex-grow flex flex-col relative overflow-hidden bg-[#fafafa]">
            
            <!-- Floating Toolbar (Horizontal Brutalist style) -->
            <div class="absolute top-4 left-4 right-4 z-20 flex flex-wrap items-center justify-between bg-white border-2 border-black p-2 brutal-shadow-sm rounded-sm gap-2">
                <!-- Left: Tools & Sizes -->
                <div class="flex items-center space-x-3 flex-wrap">
                    <span class="text-[10px] font-bold font-mono text-gray-500 uppercase mr-1">Tools:</span>
                    <div class="flex items-center border-2 border-black p-0.5 space-x-0.5 bg-gray-50 rounded-sm">
                        <button data-tool="select" class="tool-btn p-1.5 border border-transparent hover:border-black rounded-sm active-tool bg-yellow-100" title="Select, Move & Resize">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l7.07 16.97 2.51-7.39 7.39-2.51L3 3z"/></svg>
                        </button>
                        <button data-tool="brush" class="tool-btn p-1.5 border border-transparent hover:border-black rounded-sm" title="Brush (Freehand)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </button>
                        <button data-tool="line" class="tool-btn p-1.5 border border-transparent hover:border-black rounded-sm" title="Straight Line">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                        </button>
                        <button data-tool="rectangle" class="tool-btn p-1.5 border border-transparent hover:border-black rounded-sm" title="Rectangle">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16v12H4z"/></svg>
                        </button>
                        <button data-tool="circle" class="tool-btn p-1.5 border border-transparent hover:border-black rounded-sm" title="Circle">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" fill="none"/></svg>
                        </button>
                        <button data-tool="text" class="tool-btn p-1.5 border border-transparent hover:border-black rounded-sm" title="Text Tool">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-6 4h6m-6 4h6M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"/></svg>
                        </button>
                        <button data-tool="eraser" class="tool-btn p-1.5 border border-transparent hover:border-black rounded-sm" title="Eraser">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>

                    <div class="h-6 w-px bg-gray-300 mx-1"></div>

                    <!-- Sizes -->
                    <span class="text-[10px] font-bold font-mono text-gray-500 uppercase mr-1">Size:</span>
                    <div class="flex items-center space-x-1.5 border-2 border-black p-1 bg-gray-50 rounded-sm">
                        <button data-size="2" class="size-btn w-2.5 h-2.5 rounded-full bg-black border border-white hover:scale-125 transition-transform active-size" title="Thin (2px)"></button>
                        <button data-size="6" class="size-btn w-3.5 h-3.5 rounded-full bg-black border border-white hover:scale-125 transition-transform" title="Medium (6px)"></button>
                        <button data-size="12" class="size-btn w-4.5 h-4.5 rounded-full bg-black border border-white hover:scale-125 transition-transform" title="Thick (12px)"></button>
                        <button data-size="24" class="size-btn w-5.5 h-5.5 rounded-full bg-black border border-white hover:scale-125 transition-transform" title="Extra Thick (24px)"></button>
                    </div>
                </div>

                <!-- Right: Colors & Actions -->
                <div class="flex items-center space-x-3 flex-wrap">
                    <span class="text-[10px] font-bold font-mono text-gray-500 uppercase mr-1">Color:</span>
                    <div class="flex items-center space-x-1 border-2 border-black p-1 bg-gray-50 rounded-sm">
                        <button class="color-btn w-4 h-4 border border-black rounded-sm hover:scale-110" style="background-color: #1a1a1a;" data-color="#1a1a1a" title="Charcoal"></button>
                        <button class="color-btn w-4 h-4 border border-black rounded-sm hover:scale-110" style="background-color: #f87171;" data-color="#f87171" title="Red"></button>
                        <button class="color-btn w-4 h-4 border border-black rounded-sm hover:scale-110" style="background-color: #60a5fa;" data-color="#60a5fa" title="Blue"></button>
                        <button class="color-btn w-4 h-4 border border-black rounded-sm hover:scale-110" style="background-color: #4ade80;" data-color="#4ade80" title="Green"></button>
                        <button class="color-btn w-4 h-4 border border-black rounded-sm hover:scale-110" style="background-color: #facc15;" data-color="#facc15" title="Yellow"></button>
                        <button class="color-btn w-4 h-4 border border-black rounded-sm hover:scale-110" style="background-color: #fb923c;" data-color="#fb923c" title="Orange"></button>
                        <button class="color-btn w-4 h-4 border border-black rounded-sm hover:scale-110" style="background-color: #c084fc;" data-color="#c084fc" title="Purple"></button>
                        <button class="color-btn w-4 h-4 border border-black rounded-sm hover:scale-110" style="background-color: #ffffff;" data-color="#ffffff" title="White"></button>
                        <label for="color-picker" class="cursor-pointer ml-1 flex items-center" title="Custom Color Picker">
                            <input type="color" id="color-picker" class="w-5 h-5 border border-black rounded-sm cursor-pointer bg-transparent" value="#1a1a1a">
                        </label>
                    </div>

                    <div class="h-6 w-px bg-gray-300 mx-1"></div>

                    <!-- Actions -->
                    <button id="btn-export" class="flex items-center space-x-1 px-2 py-1 border-2 border-black hover:bg-gray-100 rounded-sm text-[10px] font-mono font-bold uppercase brutal-shadow-xs" title="Export to PNG">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Export</span>
                    </button>
                    <button id="btn-clear" class="flex items-center space-x-1 px-2 py-1 bg-red-500 text-white hover:bg-red-600 border-2 border-black brutal-shadow-xs rounded-sm text-[10px] font-mono font-bold uppercase transition-colors" title="Clear All Drawings">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Clear All</span>
                    </button>
                    <button id="btn-toggle-chat" class="flex items-center space-x-1 px-2 py-1 bg-blue-500 text-white hover:bg-blue-600 border-2 border-black brutal-shadow-xs rounded-sm text-[10px] font-mono font-bold uppercase transition-colors" title="Toggle Chat Panel">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <span>Chat</span>
                    </button>
                </div>
            </div>

            <!-- Canvas Element -->
            <canvas id="whiteboard-canvas" class="w-full h-full cursor-crosshair touch-none" style="background-image: radial-gradient(circle, #e2e8f0 1.5px, transparent 1.5px); background-size: 20px 20px;"></canvas>

            <!-- Cursors container overlay -->
            <div id="cursors-overlay" class="absolute inset-0 pointer-events-none overflow-hidden z-10"></div>

            <!-- In-place text input overlay -->
            <div id="text-input-overlay" class="absolute hidden z-30">
                <input type="text" id="text-input-field" class="border-2 border-black p-1 font-mono text-sm focus:outline-none brutal-shadow-xs" placeholder="Press Enter to add...">
            </div>
        </div>

        <!-- Chat Panel (Right) -->
        <div id="chat-panel" class="w-full md:w-80 bg-white flex flex-col h-full border-t-2 md:border-t-0 md:border-l-2 border-black overflow-hidden z-10 brutal-shadow-sm transition-all duration-300">
            <div class="border-b-2 border-black p-3 bg-[#f4f3ef] flex items-center justify-between">
                <h3 class="font-bold uppercase text-sm tracking-wider font-mono">Team Chat</h3>
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            </div>
            
            <!-- Chat Messages Container -->
            <div id="chat-messages-container" class="flex-grow p-4 overflow-y-auto space-y-4 bg-[#fafafa]">
                @forelse($chatMessages as $msg)
                <div class="flex flex-col" data-chat-id="{{ $msg->id }}">
                    <div class="flex items-baseline space-x-2 mb-1">
                        <span class="font-bold text-xs uppercase" style="color: {{ $msg->color }}">{{ $msg->username }}</span>
                        <span class="font-mono text-[9px] text-gray-500">
                            {{ \Carbon\Carbon::createFromTimestampMs($msg->created_at_ms)->timezone(config('app.timezone', 'UTC'))->format('g:i A') }}
                        </span>
                    </div>
                    <div class="border border-black p-2.5 text-xs font-mono bg-white brutal-shadow-xs max-w-[90%] rounded-sm">
                        {{ $msg->message }}
                    </div>
                </div>
                @empty
                <div id="chat-empty-state" class="text-center py-8 text-gray-400 font-mono text-xs">
                    No messages yet. Start collaborating!
                </div>
                @endforelse
            </div>

            <!-- Chat Input form -->
            <div class="p-3 border-t-2 border-black bg-[#f4f3ef]">
                <form id="chat-form" class="flex border-2 border-black bg-white brutal-shadow-xs">
                    <input type="text" id="chat-input" placeholder="Type a message..." class="flex-grow p-2 font-mono text-xs focus:outline-none" autocomplete="off">
                    <button type="submit" class="border-l-2 border-black px-4 bg-black text-white hover:bg-gray-800 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Dialogs -->
<div id="modal-share" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white border-4 border-black p-6 w-full max-w-md brutal-shadow rounded-sm">
        <h3 class="font-bold text-lg uppercase font-mono mb-4 border-b-2 border-black pb-2">Invite Collaborators</h3>
        <p class="text-xs font-mono mb-4 text-gray-600">Share this link with other registered users so they can join the whiteboard in real-time:</p>
        <div class="flex border-2 border-black mb-4">
            <input type="text" id="share-link-input" class="flex-grow p-2 font-mono text-xs focus:outline-none" readonly>
            <button id="btn-copy-link" class="bg-yellow-300 border-l-2 border-black px-4 font-mono font-bold text-xs uppercase hover:bg-yellow-400 transition-colors">Copy</button>
        </div>
        <div class="flex justify-end">
            <button id="btn-close-share" class="border-2 border-black px-4 py-1.5 font-mono text-xs uppercase font-bold hover:bg-gray-100 brutal-shadow-xs">Close</button>
        </div>
    </div>
</div>

<!-- Custom JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- State Variables ---
        const currentUser = {
            id: "{{ $user->id }}",
            name: "{{ $user->name }}",
            color: "{{ $userColor }}"
        };

        let lastSyncTime = {{ $serverTimeMs }};
        let activeTool = 'select'; // 'select', 'brush', 'line', 'rectangle', 'circle', 'text', 'eraser'
        let strokeColor = '#1a1a1a';
        let strokeSize = 2;

        let isDrawing = false;
        let startPoint = null; // { x, y } in internal coordinates
        let currentPoint = null; // {x, y}
        let strokePoints = []; // Accumulator for brush path
        
        let pendingActions = []; // Actions to send in next sync
        let pendingChatMessage = null; // Chat message to send in next sync

        // Object Whiteboard State
        let shapes = []; // List of active shapes drawn or synchronized
        let selectedShape = null; // Currently selected shape object
        let isDraggingShape = false;
        let isResizingShape = false;
        let activeResizeHandle = null; // 'tl', 'tr', 'bl', 'br'
        let dragStartPoint = null;
        let originalShapeState = null; // Stores original points and size during drag/resize

        // Cursors position interpolation (LERP) dictionary
        // { userId: { element, currentX, currentY, targetX, targetY, color, name } }
        const remoteUsers = {};

        // Sets for deduplicating real-time actions and chat messages
        const drawnActionIds = new Set();
        const processedChatIds = new Set();

        // --- Canvas Setup ---
        const canvas = document.getElementById('whiteboard-canvas');
        const ctx = canvas.getContext('2d');
        const cursorsOverlay = document.getElementById('cursors-overlay');
        const textInputOverlay = document.getElementById('text-input-overlay');
        const textInputField = document.getElementById('text-input-field');

        // Internal resolution setup (1920x1080) for resolution-independent coordinate systems
        canvas.width = 1920;
        canvas.height = 1080;

        // Populate initial action IDs
        const initialActions = @json($actions);
        initialActions.forEach(act => {
            const actId = act.id || act._id;
            if (actId) drawnActionIds.add(actId);
        });

        // Populate initial chat message IDs from DOM
        document.querySelectorAll('#chat-messages-container [data-chat-id]').forEach(el => {
            const chatId = el.dataset.chatId;
            if (chatId) processedChatIds.add(chatId);
        });

        // Render initial paths
        drawActions(initialActions);

        // --- Helper: Coordinate Conversion ---
        function getCanvasCoords(e) {
            const rect = canvas.getBoundingClientRect();
            // Support both Mouse and Touch events
            let clientX, clientY;
            if (e.touches && e.touches.length > 0) {
                clientX = e.touches[0].clientX;
                clientY = e.touches[0].clientY;
            } else {
                clientX = e.clientX;
                clientY = e.clientY;
            }

            const pctX = (clientX - rect.left) / rect.width;
            const pctY = (clientY - rect.top) / rect.height;

            return {
                x: pctX * canvas.width,
                y: pctY * canvas.height,
                pctX: pctX,
                pctY: pctY
            };
        }

        // --- Drawing Operations ---
        function drawActions(actionsList) {
            let hasChanges = false;
            actionsList.forEach(action => {
                const actionId = action.id || action._id;
                if (actionId) {
                    action.id = actionId;
                }

                if (action.type === 'clear') {
                    if (!drawnActionIds.has('clear_' + action.created_at_ms)) {
                        drawnActionIds.add('clear_' + action.created_at_ms);
                        clearCanvasLocally();
                        hasChanges = true;
                    }
                    return;
                }

                // Check if this action already exists in our shapes list
                const existingIndex = shapes.findIndex(s => s.id === action.id);
                if (existingIndex !== -1) {
                    const existingShape = shapes[existingIndex];
                    // Skip if the shape hasn't been updated (same timestamp)
                    if (existingShape.created_at_ms === action.created_at_ms) {
                        return;
                    }
                    
                    if (action.type === 'deleted') {
                        // Remove from shapes list
                        shapes.splice(existingIndex, 1);
                        if (selectedShape && selectedShape.id === action.id) {
                            selectedShape = null;
                        }
                    } else {
                        // Update shape properties
                        shapes[existingIndex] = action;
                        // If it's the currently selected shape, update our reference
                        if (selectedShape && selectedShape.id === action.id) {
                            selectedShape = action;
                        }
                    }
                    hasChanges = true;
                } else if (action.type !== 'deleted') {
                    // Append new shape
                    shapes.push(action);
                    hasChanges = true;
                }
            });

            if (hasChanges) {
                redrawAllShapes();
            }
        }

        function redrawAllShapes() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // Draw shapes
            shapes.forEach(shape => {
                if (shape.type === 'clear' || shape.type === 'deleted') return;

                ctx.save();
                ctx.lineWidth = shape.size || 2;
                
                if (shape.type === 'eraser') {
                    ctx.globalCompositeOperation = 'destination-out';
                    ctx.strokeStyle = 'rgba(0,0,0,1)';
                } else {
                    ctx.globalCompositeOperation = 'source-over';
                    ctx.strokeStyle = shape.color;
                    ctx.fillStyle = shape.color;
                }

                const pts = shape.points;
                if (shape.type === 'brush' || shape.type === 'stroke' || shape.type === 'eraser') {
                    if (pts && pts.length > 0) {
                        ctx.beginPath();
                        ctx.moveTo(pts[0].x, pts[0].y);
                        for (let i = 1; i < pts.length; i++) {
                            ctx.lineTo(pts[i].x, pts[i].y);
                        }
                        ctx.stroke();
                    }
                } else if (shape.type === 'line') {
                    if (pts && pts.length >= 2) {
                        ctx.beginPath();
                        ctx.moveTo(pts[0].x, pts[0].y);
                        ctx.lineTo(pts[1].x, pts[1].y);
                        ctx.stroke();
                    }
                } else if (shape.type === 'rectangle') {
                    if (pts && pts.length >= 2) {
                        const width = pts[1].x - pts[0].x;
                        const height = pts[1].y - pts[0].y;
                        ctx.beginPath();
                        ctx.rect(pts[0].x, pts[0].y, width, height);
                        ctx.stroke();
                    }
                } else if (shape.type === 'circle') {
                    if (pts && pts.length >= 2) {
                        const radius = Math.sqrt(
                            Math.pow(pts[1].x - pts[0].x, 2) + 
                            Math.pow(pts[1].y - pts[0].y, 2)
                        );
                        ctx.beginPath();
                        ctx.arc(pts[0].x, pts[0].y, radius, 0, 2 * Math.PI);
                        ctx.stroke();
                    }
                } else if (shape.type === 'text') {
                    if (pts && pts.length > 0) {
                        ctx.font = `${(shape.size * 3) + 12}px monospace`;
                        ctx.fillText(shape.text, pts[0].x, pts[0].y);
                    }
                }
                ctx.restore();
            });

            // If select tool is active and a shape is selected, draw its bounding box & handles
            if (activeTool === 'select' && selectedShape) {
                const bbox = getShapeBoundingBox(selectedShape);
                if (bbox) {
                    ctx.save();
                    // Draw dashed bounding box
                    ctx.strokeStyle = '#3b82f6';
                    ctx.lineWidth = 2;
                    ctx.setLineDash([6, 4]);
                    ctx.strokeRect(bbox.x, bbox.y, bbox.w, bbox.h);
                    ctx.restore();

                    // Draw corner handles
                    ctx.save();
                    ctx.fillStyle = '#ffffff';
                    ctx.strokeStyle = '#3b82f6';
                    ctx.lineWidth = 2;
                    const handles = getHandles(bbox);
                    Object.keys(handles).forEach(h => {
                        const pt = handles[h];
                        ctx.fillRect(pt.x - 4, pt.y - 4, 8, 8);
                        ctx.strokeRect(pt.x - 4, pt.y - 4, 8, 8);
                    });
                    ctx.restore();
                }
            }
            
            // Toggle delete button visibility based on selection
            const deleteBtn = document.getElementById('btn-delete-selected');
            if (deleteBtn) {
                if (activeTool === 'select' && selectedShape) {
                    deleteBtn.classList.remove('hidden');
                } else {
                    deleteBtn.classList.add('hidden');
                }
            }

            // Restore in-progress stroke if currently drawing so sync doesn't erase it
            if (isDrawing && (activeTool === 'brush' || activeTool === 'eraser') && strokePoints && strokePoints.length > 0) {
                ctx.save();
                ctx.lineWidth = strokeSize;
                if (activeTool === 'eraser') {
                    ctx.globalCompositeOperation = 'destination-out';
                    ctx.strokeStyle = 'rgba(0,0,0,1)';
                } else {
                    ctx.globalCompositeOperation = 'source-over';
                    ctx.strokeStyle = strokeColor;
                }
                ctx.beginPath();
                ctx.moveTo(strokePoints[0].x, strokePoints[0].y);
                for (let i = 1; i < strokePoints.length; i++) {
                    ctx.lineTo(strokePoints[i].x, strokePoints[i].y);
                }
                ctx.stroke();
                ctx.restore();
            }
        }

        function clearCanvasLocally() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            shapes = [];
            selectedShape = null;
            drawnActionIds.clear();
            redrawAllShapes();
        }

        function generateUniqueId() {
            return 'shape_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        }

        // --- Vector Hit Testing & Scaling ---
        function getShapeBoundingBox(shape) {
            const pts = shape.points;
            if (!pts || pts.length === 0) return null;

            if (shape.type === 'rectangle' || shape.type === 'line') {
                const minX = Math.min(pts[0].x, pts[1].x);
                const maxX = Math.max(pts[0].x, pts[1].x);
                const minY = Math.min(pts[0].y, pts[1].y);
                const maxY = Math.max(pts[0].y, pts[1].y);
                return { x: minX, y: minY, w: maxX - minX, h: maxY - minY };
            } else if (shape.type === 'circle') {
                const cx = pts[0].x;
                const cy = pts[0].y;
                const radius = Math.sqrt(Math.pow(pts[1].x - pts[0].x, 2) + Math.pow(pts[1].y - pts[0].y, 2));
                return { x: cx - radius, y: cy - radius, w: radius * 2, h: radius * 2 };
            } else if (shape.type === 'text') {
                const x = pts[0].x;
                const y = pts[0].y;
                const fontSize = (shape.size * 3) + 12;
                const w = (shape.text || '').length * (fontSize * 0.6);
                const h = fontSize;
                return { x: x, y: y - h, w: w, h: h };
            } else if (shape.type === 'brush' || shape.type === 'eraser') {
                let minX = pts[0].x, maxX = pts[0].x;
                let minY = pts[0].y, maxY = pts[0].y;
                for (let i = 1; i < pts.length; i++) {
                    minX = Math.min(minX, pts[i].x);
                    maxX = Math.max(maxX, pts[i].x);
                    minY = Math.min(minY, pts[i].y);
                    maxY = Math.max(maxY, pts[i].y);
                }
                return { x: minX, y: minY, w: maxX - minX, h: maxY - minY };
            }
            return null;
        }

        function getHandles(bbox) {
            return {
                tl: { x: bbox.x, y: bbox.y },
                tr: { x: bbox.x + bbox.w, y: bbox.y },
                bl: { x: bbox.x, y: bbox.y + bbox.h },
                br: { x: bbox.x + bbox.w, y: bbox.y + bbox.h }
            };
        }

        function isPointInShape(px, py, shape) {
            const bbox = getShapeBoundingBox(shape);
            if (!bbox) return false;
            const pad = 10;
            return px >= bbox.x - pad && px <= bbox.x + bbox.w + pad &&
                   py >= bbox.y - pad && py <= bbox.y + bbox.h + pad;
        }

        function getClickedHandle(px, py, bbox) {
            if (!bbox) return null;
            const handles = getHandles(bbox);
            const tolerance = 10;
            for (const key of Object.keys(handles)) {
                const h = handles[key];
                if (Math.abs(px - h.x) <= tolerance && Math.abs(py - h.y) <= tolerance) {
                    return key;
                }
            }
            return null;
        }

        // --- Mouse / Touch Events (Local Drawing) ---
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        window.addEventListener('mouseup', stopDrawing);

        canvas.addEventListener('touchstart', (e) => {
            e.preventDefault();
            startDrawing(e);
        }, { passive: false });
        canvas.addEventListener('touchmove', (e) => {
            e.preventDefault();
            draw(e);
        }, { passive: false });
        window.addEventListener('touchend', stopDrawing);
        
        // Handle Delete key for removing selected shapes
        window.addEventListener('keydown', (e) => {
            if (activeTool === 'select' && selectedShape && (e.key === 'Delete' || e.key === 'Backspace')) {
                // Focus check: do not delete shape if typing in an input
                if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') {
                    return;
                }
                
                selectedShape.type = 'deleted';
                pendingActions.push(JSON.parse(JSON.stringify(selectedShape)));
                
                const index = shapes.findIndex(s => s.id === selectedShape.id);
                if (index !== -1) {
                    shapes.splice(index, 1);
                }
                selectedShape = null;
                redrawAllShapes();
            }
        });

        // Tracking relative cursor position for other users
        let currentRelativeCursor = { x: 0.5, y: 0.5 };
        canvas.addEventListener('mousemove', (e) => {
            const coords = getCanvasCoords(e);
            currentRelativeCursor = { x: coords.pctX, y: coords.pctY };
        });

        canvas.addEventListener('touchmove', (e) => {
            if (e.touches && e.touches.length > 0) {
                const coords = getCanvasCoords(e);
                currentRelativeCursor = { x: coords.pctX, y: coords.pctY };
            }
        });

        function startDrawing(e) {
            if (activeTool !== 'text' && !textInputOverlay.classList.contains('hidden')) {
                textInputOverlay.classList.add('hidden');
            }

            const coords = getCanvasCoords(e);
            
            // Pointer Selection & Dragging
            if (activeTool === 'select') {
                if (selectedShape) {
                    const bbox = getShapeBoundingBox(selectedShape);
                    const handle = getClickedHandle(coords.x, coords.y, bbox);
                    if (handle) {
                        isResizingShape = true;
                        activeResizeHandle = handle;
                        dragStartPoint = { x: coords.x, y: coords.y };
                        originalShapeState = {
                            points: JSON.parse(JSON.stringify(selectedShape.points)),
                            size: selectedShape.size,
                            bbox: bbox
                        };
                        return;
                    }
                }

                // Check if clicking on any shape (highest z-index first)
                let found = null;
                for (let i = shapes.length - 1; i >= 0; i--) {
                    if (isPointInShape(coords.x, coords.y, shapes[i])) {
                        found = shapes[i];
                        break;
                    }
                }
                
                if (found) {
                    selectedShape = found;
                    isDraggingShape = true;
                    dragStartPoint = { x: coords.x, y: coords.y };
                    originalShapeState = {
                        points: JSON.parse(JSON.stringify(selectedShape.points))
                    };
                    redrawAllShapes();
                } else {
                    selectedShape = null;
                    redrawAllShapes();
                }
                return;
            }

            // Normal Drawing
            isDrawing = true;
            startPoint = { x: coords.x, y: coords.y };
            currentPoint = { x: coords.x, y: coords.y };
            
            if (activeTool === 'brush' || activeTool === 'eraser') {
                strokePoints = [startPoint];
                ctx.save();
                ctx.beginPath();
                ctx.moveTo(startPoint.x, startPoint.y);
                ctx.lineWidth = strokeSize;
                if (activeTool === 'eraser') {
                    ctx.globalCompositeOperation = 'destination-out';
                    ctx.strokeStyle = 'rgba(0,0,0,1)';
                } else {
                    ctx.globalCompositeOperation = 'source-over';
                    ctx.strokeStyle = strokeColor;
                }
            } else if (activeTool === 'text') {
                const rect = canvas.getBoundingClientRect();
                const clickX = e.touches ? e.touches[0].clientX : e.clientX;
                const clickY = e.touches ? e.touches[0].clientY : e.clientY;
                
                textInputOverlay.style.left = `${clickX - rect.left}px`;
                textInputOverlay.style.top = `${clickY - rect.top}px`;
                textInputOverlay.classList.remove('hidden');
                textInputField.value = '';
                setTimeout(() => textInputField.focus(), 50);

                isDrawing = false;
            }
        }

        function draw(e) {
            const coords = getCanvasCoords(e);
            
            if (activeTool === 'select') {
                if (isDraggingShape && selectedShape && originalShapeState) {
                    const dx = coords.x - dragStartPoint.x;
                    const dy = coords.y - dragStartPoint.y;
                    selectedShape.points = originalShapeState.points.map(pt => ({
                        x: pt.x + dx,
                        y: pt.y + dy
                    }));
                    redrawAllShapes();
                } else if (isResizingShape && selectedShape && originalShapeState) {
                    const dx = coords.x - dragStartPoint.x;
                    const dy = coords.y - dragStartPoint.y;
                    
                    if (selectedShape.type === 'circle') {
                        const cx = originalShapeState.points[0].x;
                        const cy = originalShapeState.points[0].y;
                        const newRadius = Math.max(1, Math.sqrt(Math.pow(coords.x - cx, 2) + Math.pow(coords.y - cy, 2)));
                        selectedShape.points[1] = { x: cx + newRadius, y: cy };
                    } else if (selectedShape.type === 'text') {
                        const bbox = originalShapeState.bbox;
                        let newSize = originalShapeState.size;
                        if (activeResizeHandle === 'br' || activeResizeHandle === 'tr') {
                            const ratio = Math.max(0.2, (bbox.w + dx) / bbox.w);
                            newSize = Math.max(1, Math.round(originalShapeState.size * ratio));
                        }
                        selectedShape.size = newSize;
                        
                        if (activeResizeHandle === 'tl' || activeResizeHandle === 'bl') {
                            selectedShape.points[0].x = originalShapeState.points[0].x + dx;
                        }
                        if (activeResizeHandle === 'tl' || activeResizeHandle === 'tr') {
                            selectedShape.points[0].y = originalShapeState.points[0].y + dy;
                        }
                    } else {
                        // General mapping for brush, eraser, line, rectangle
                        const bbox = originalShapeState.bbox;
                        let newX = bbox.x;
                        let newY = bbox.y;
                        let newW = bbox.w;
                        let newH = bbox.h;

                        if (activeResizeHandle === 'br') {
                            newW = Math.max(10, bbox.w + dx);
                            newH = Math.max(10, bbox.h + dy);
                        } else if (activeResizeHandle === 'tl') {
                            newX = Math.min(bbox.x + bbox.w - 10, bbox.x + dx);
                            newY = Math.min(bbox.y + bbox.h - 10, bbox.y + dy);
                            newW = (bbox.x + bbox.w) - newX;
                            newH = (bbox.y + bbox.h) - newY;
                        } else if (activeResizeHandle === 'tr') {
                            newY = Math.min(bbox.y + bbox.h - 10, bbox.y + dy);
                            newW = Math.max(10, bbox.w + dx);
                            newH = (bbox.y + bbox.h) - newY;
                        } else if (activeResizeHandle === 'bl') {
                            newX = Math.min(bbox.x + bbox.w - 10, bbox.x + dx);
                            newW = (bbox.x + bbox.w) - newX;
                            newH = Math.max(10, bbox.h + dy);
                        }

                        selectedShape.points = originalShapeState.points.map(pt => {
                            const pctX = (pt.x - bbox.x) / (bbox.w || 1);
                            const pctY = (pt.y - bbox.y) / (bbox.h || 1);
                            return {
                                x: newX + pctX * newW,
                                y: newY + pctY * newH
                            };
                        });
                    }
                    redrawAllShapes();
                }
                return;
            }

            if (!isDrawing) return;
            currentPoint = { x: coords.x, y: coords.y };

            if (activeTool === 'brush' || activeTool === 'eraser') {
                strokePoints.push(currentPoint);
                // Draw current stroke directly for instant feedback
                ctx.lineTo(currentPoint.x, currentPoint.y);
                ctx.stroke();
            } else {
                // Clear and redraw all shapes, then draw the live preview
                redrawAllShapes();

                ctx.save();
                ctx.lineWidth = strokeSize;
                ctx.strokeStyle = strokeColor;
                ctx.fillStyle = strokeColor;

                if (activeTool === 'line') {
                    ctx.beginPath();
                    ctx.moveTo(startPoint.x, startPoint.y);
                    ctx.lineTo(currentPoint.x, currentPoint.y);
                    ctx.stroke();
                } else if (activeTool === 'rectangle') {
                    const w = currentPoint.x - startPoint.x;
                    const h = currentPoint.y - startPoint.y;
                    ctx.beginPath();
                    ctx.rect(startPoint.x, startPoint.y, w, h);
                    ctx.stroke();
                } else if (activeTool === 'circle') {
                    const radius = Math.sqrt(
                        Math.pow(currentPoint.x - startPoint.x, 2) + 
                        Math.pow(currentPoint.y - startPoint.y, 2)
                    );
                    ctx.beginPath();
                    ctx.arc(startPoint.x, startPoint.y, radius, 0, 2 * Math.PI);
                    ctx.stroke();
                }
                ctx.restore();
            }
        }

        function stopDrawing(e) {
            if (activeTool === 'select') {
                if ((isDraggingShape || isResizingShape) && selectedShape) {
                    pendingActions.push(JSON.parse(JSON.stringify(selectedShape)));
                }
                isDraggingShape = false;
                isResizingShape = false;
                activeResizeHandle = null;
                return;
            }

            if (!isDrawing) return;
            isDrawing = false;

            const actionId = generateUniqueId();
            let action = {
                id: actionId,
                type: activeTool,
                color: activeTool === 'eraser' ? '#ffffff' : strokeColor,
                size: strokeSize,
                created_at_ms: Date.now()
            };

            if (activeTool === 'brush' || activeTool === 'eraser') {
                ctx.restore(); // restore global composite operation state
                if (strokePoints.length > 1) {
                    action.points = strokePoints;
                    shapes.push(action);
                    pendingActions.push(action);
                }
                strokePoints = [];
            } else {
                // For lines/rectangles/circles
                action.points = [startPoint, currentPoint];
                shapes.push(action);
                pendingActions.push(action);
            }
            redrawAllShapes();
        }

        // Commit Text Action on Enter
        textInputField.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                const textVal = textInputField.value.trim();
                if (textVal) {
                    // Calculate canvas relative coords from the overlay position
                    const rect = canvas.getBoundingClientRect();
                    const overlayLeft = parseFloat(textInputOverlay.style.left);
                    const overlayTop = parseFloat(textInputOverlay.style.top);

                    const canvasRelativeX = (overlayLeft / rect.width) * canvas.width;
                    const canvasRelativeY = ((overlayTop + 20) / rect.height) * canvas.height; // small offset for text baseline

                    const actionId = generateUniqueId();
                    const action = {
                        id: actionId,
                        type: 'text',
                        color: strokeColor,
                        size: strokeSize,
                        points: [{ x: canvasRelativeX, y: canvasRelativeY }],
                        text: textVal,
                        created_at_ms: Date.now()
                    };
                    shapes.push(action);
                    pendingActions.push(action);
                    redrawAllShapes();
                }
                textInputOverlay.classList.add('hidden');
            }
        });

        // Close text input overlay when clicking outside
        document.addEventListener('mousedown', (e) => {
            if (!textInputOverlay.classList.contains('hidden') && 
                !textInputOverlay.contains(e.target) && 
                e.target !== canvas) {
                textInputOverlay.classList.add('hidden');
            }
        });

        // --- Toolbar Action Listeners ---
        // Tools Selection
        document.querySelectorAll('.tool-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tool-btn').forEach(b => b.classList.remove('active-tool', 'bg-yellow-100'));
                btn.classList.add('active-tool', 'bg-yellow-100');
                activeTool = btn.dataset.tool;
            });
        });

        // Sizes Selection
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active-size', 'scale-125'));
                btn.classList.add('active-size', 'scale-125');
                strokeSize = parseInt(btn.dataset.size);
            });
        });

        // Colors Selection
        document.querySelectorAll('.color-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                strokeColor = btn.dataset.color;
                document.getElementById('color-picker').value = strokeColor;
            });
        });

        // Custom Color Picker
        document.getElementById('color-picker').addEventListener('input', (e) => {
            strokeColor = e.target.value;
        });

        // --- Export PNG ---
        document.getElementById('btn-export').addEventListener('click', () => {
            // Create a temporary canvas with white background to export (so transparency isn't exported as black in some software)
            const exportCanvas = document.createElement('canvas');
            exportCanvas.width = canvas.width;
            exportCanvas.height = canvas.height;
            const exportCtx = exportCanvas.getContext('2d');
            
            // Draw background
            exportCtx.fillStyle = '#ffffff';
            exportCtx.fillRect(0, 0, exportCanvas.width, exportCanvas.height);
            
            // Draw current canvas on top
            exportCtx.drawImage(canvas, 0, 0);

            // Trigger download link
            const dataURL = exportCanvas.toDataURL('image/png');
            const link = document.createElement('a');
            link.download = `whiteboard-${Date.now()}.png`;
            link.href = dataURL;
            link.click();
        });

        // --- Clear Canvas ---
        document.getElementById('btn-clear').addEventListener('click', () => {
            if (confirm('Are you sure you want to clear the entire whiteboard for everyone?')) {
                clearCanvasLocally();
                
                // Send clear instruction to server
                fetch("{{ route('workspace.clear', ['uuid' => $whiteboard->uuid]) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Whiteboard cleared on server');
                })
                .catch(err => console.error('Error clearing whiteboard:', err));
            }
        });

        // --- Real-Time Sync Loop ---
        async function syncState() {
            // Construct sync payload
            if (pendingActions.length === 0 && !pendingChatMessage) {
                return; // Nothing to sync
            }

            const payload = {
                actions: pendingActions,
                chat_message: pendingChatMessage
            };

            // Reset pending queues
            pendingActions = [];
            pendingChatMessage = null;

            try {
                const response = await fetch("{{ route('workspace.sync', ['uuid' => $whiteboard->uuid]) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                });

                if (!response.ok) throw new Error('Sync request failed');
            } catch (err) {
                console.error('Sync Error:', err);
            }
        }

        // --- Chat Operations ---
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatContainer = document.getElementById('chat-messages-container');

        chatForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const msg = chatInput.value.trim();
            if (!msg) return;

            // Set message to send in next sync tick
            pendingChatMessage = msg;

            // Append locally instantly for responsive UX
            appendChatMessages([{
                id: 'local_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                user_id: currentUser.id,
                username: currentUser.name,
                message: msg,
                color: currentUser.color,
                created_at_ms: Date.now()
            }], false);

            chatInput.value = '';
        });

        function appendChatMessages(messages, isSync = false) {
            const emptyState = document.getElementById('chat-empty-state');
            if (emptyState) emptyState.remove();

            messages.forEach(msg => {
                const msgId = msg.id || msg._id;
                if (msgId) {
                    if (processedChatIds.has(msgId)) return;
                    processedChatIds.add(msgId);
                }

                // Prevent duplicate rendering of own message during sync ticks
                if (isSync && msg.user_id === currentUser.id) {
                    return;
                }

                // Format timestamp
                const date = new Date(msg.created_at_ms);
                const timeStr = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                const msgHtml = `
                    <div class="flex flex-col" data-chat-id="${msgId || ''}">
                        <div class="flex items-baseline space-x-2 mb-1">
                            <span class="font-bold text-xs uppercase" style="color: ${msg.color}">${msg.username}</span>
                            <span class="font-mono text-[9px] text-gray-500">${timeStr}</span>
                        </div>
                        <div class="border border-black p-2.5 text-xs font-mono bg-white brutal-shadow-xs max-w-[90%] rounded-sm">
                            ${escapeHTML(msg.message)}
                        </div>
                    </div>
                `;
                chatContainer.insertAdjacentHTML('beforeend', msgHtml);
            });

            // Scroll to bottom
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function escapeHTML(str) {
            return str.replace(/[&<>'"]/g, 
                tag => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    "'": '&#39;',
                    '"': '&quot;'
                }[tag] || tag)
            );
        }

        // --- Cursors Interpolation (LERP) Loop ---
        function updateActiveCollaborators(onlineUsers) {
            const activeUserIds = new Set();
            const avatarsContainer = document.getElementById('active-avatars-container');
            
            // Keep the current user's avatar
            let avatarsHtml = `
                <div class="w-8 h-8 rounded-full border-2 border-black flex items-center justify-center text-white font-mono text-xs font-bold z-30" style="background-color: ${currentUser.color};" title="${currentUser.name} (You)">
                    ${currentUser.name.charAt(0).toUpperCase()}
                </div>
            `;

            onlineUsers.forEach(u => {
                activeUserIds.add(u.user_id);

                // Add to avatars stack
                avatarsHtml += `
                    <div class="w-8 h-8 rounded-full border-2 border-black flex items-center justify-center text-white font-mono text-xs font-bold z-20" style="background-color: ${u.color};" title="${u.name}">
                        ${u.name.charAt(0).toUpperCase()}
                    </div>
                `;

                // Handle cursor element
                if (!remoteUsers[u.user_id]) {
                    // Create new cursor element
                    const cursorEl = document.createElement('div');
                    cursorEl.className = 'absolute pointer-events-none flex flex-col items-start transition-opacity duration-300';
                    cursorEl.style.opacity = '0';
                    cursorEl.innerHTML = `
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" style="color: ${u.color};">
                            <path d="M1 1L6 14L8.5 9L14 7L1 1Z" fill="currentColor" stroke="white" stroke-width="1"/>
                        </svg>
                        <div class="text-white font-mono text-[9px] px-1 ml-3 -mt-1 rounded-sm brutal-shadow-xs" style="background-color: ${u.color}; border: 1px solid black;">
                            ${u.name}
                        </div>
                    `;
                    cursorsOverlay.appendChild(cursorEl);

                    remoteUsers[u.user_id] = {
                        element: cursorEl,
                        currentX: u.x || 0.5,
                        currentY: u.y || 0.5,
                        targetX: u.x || 0.5,
                        targetY: u.y || 0.5,
                        color: u.color,
                        name: u.name
                    };

                    setTimeout(() => { cursorEl.style.opacity = '1'; }, 50);
                } else {
                    // Update interpolation target coordinates
                    if (u.x !== undefined && u.y !== undefined) {
                        remoteUsers[u.user_id].targetX = u.x;
                        remoteUsers[u.user_id].targetY = u.y;
                    }
                }
            });

            // Update header avatars
            avatarsContainer.innerHTML = avatarsHtml;

            // Delete offline cursors
            Object.keys(remoteUsers).forEach(uid => {
                if (!activeUserIds.has(uid)) {
                    const userCursor = remoteUsers[uid];
                    userCursor.element.style.opacity = '0';
                    setTimeout(() => {
                        userCursor.element.remove();
                    }, 300);
                    delete remoteUsers[uid];
                }
            });
        }

        // LERP Loop running at 60fps (requestAnimationFrame)
        function animateCursors() {
            const rect = canvas.getBoundingClientRect();

            Object.keys(remoteUsers).forEach(uid => {
                const user = remoteUsers[uid];

                // Linear Interpolation: current = current + (target - current) * lerpFactor
                user.currentX += (user.targetX - user.currentX) * 0.15;
                user.currentY += (user.targetY - user.currentY) * 0.15;

                // Scale normalized positions (0-1) to actual pixels matching the DOM sizing of the overlay container
                const pixelX = user.currentX * rect.width;
                const pixelY = user.currentY * rect.height;

                user.element.style.left = `${pixelX}px`;
                user.element.style.top = `${pixelY}px`;
            });

            requestAnimationFrame(animateCursors);
        }

        animateCursors();

        // --- Chat Toggle Logic ---
        document.getElementById('btn-toggle-chat').addEventListener('click', () => {
            const chatPanel = document.getElementById('chat-panel');
            if (chatPanel.classList.contains('hidden')) {
                chatPanel.classList.remove('hidden');
                chatPanel.classList.add('flex');
            } else {
                chatPanel.classList.add('hidden');
                chatPanel.classList.remove('flex');
            }
        });

        // Send actions to server every 200ms if there are any
        setInterval(syncState, 200);

        // --- Laravel Echo Integration ---
        let echoChannel = null;
        // Keep a list of all currently joined users to pass to updateActiveCollaborators
        let currentOnlineUsers = [];

        if (window.Echo) {
            echoChannel = window.Echo.join(`whiteboard.{{ $whiteboard->uuid }}`);
            
            echoChannel.here((users) => {
                currentOnlineUsers = users.filter(u => u.id != currentUser.id).map(u => ({
                    user_id: u.id,
                    name: u.name,
                    color: u.color
                }));
                updateActiveCollaborators(currentOnlineUsers);
            })
            .joining((user) => {
                if (user.id != currentUser.id) {
                    currentOnlineUsers.push({
                        user_id: user.id,
                        name: user.name,
                        color: user.color
                    });
                    updateActiveCollaborators(currentOnlineUsers);
                }
            })
            .leaving((user) => {
                currentOnlineUsers = currentOnlineUsers.filter(u => u.user_id != user.id);
                updateActiveCollaborators(currentOnlineUsers);
            })
            .listen('WhiteboardActionDispatched', (e) => {
                if (e.actions) {
                    drawActions(e.actions);
                }
            })
            .listen('WhiteboardChatDispatched', (e) => {
                if (e.message) {
                    appendChatMessages([e.message], true);
                }
            })
            .listen('WhiteboardCleared', (e) => {
                if (e.action) {
                    drawActions([e.action]);
                }
            })
            .listenForWhisper('cursor-move', (e) => {
                // Update specific user's cursor
                // Find user in currentOnlineUsers, add x and y
                const userIndex = currentOnlineUsers.findIndex(u => u.user_id == e.user_id);
                if (userIndex !== -1) {
                    currentOnlineUsers[userIndex].x = e.x;
                    currentOnlineUsers[userIndex].y = e.y;
                    updateActiveCollaborators(currentOnlineUsers);
                }
            });
            
            // Broadcast our cursor movement every 100ms
            setInterval(() => {
                echoChannel.whisper('cursor-move', {
                    user_id: currentUser.id,
                    name: currentUser.name,
                    color: currentUser.color,
                    x: currentRelativeCursor.x,
                    y: currentRelativeCursor.y
                });
            }, 100);
        }

        // --- Share Board Modal Logic ---
        const modalShare = document.getElementById('modal-share');
        const shareLinkInput = document.getElementById('share-link-input');

        document.getElementById('btn-share').addEventListener('click', () => {
            shareLinkInput.value = window.location.href;
            modalShare.classList.remove('hidden');
        });

        document.getElementById('btn-close-share').addEventListener('click', () => {
            modalShare.classList.add('hidden');
        });

        document.getElementById('btn-copy-link').addEventListener('click', () => {
            shareLinkInput.select();
            document.execCommand('copy');
            const btnCopy = document.getElementById('btn-copy-link');
            const oldText = btnCopy.textContent;
            btnCopy.textContent = 'Copied!';
            btnCopy.style.backgroundColor = '#4ade80';
            setTimeout(() => {
                btnCopy.textContent = oldText;
                btnCopy.style.backgroundColor = '';
            }, 1500);
        });

        window.addEventListener('click', (e) => {
            if (e.target === modalShare) {
                modalShare.classList.add('hidden');
            }
        });
    });
</script>

<style>
    .active-tool {
        border-color: black !important;
        background-color: #fef08a !important; /* bright yellow background */
        box-shadow: 2px 2px 0px 0px #000;
        transform: translate(-1px, -1px);
    }
    .active-size {
        outline: 2px solid black;
        outline-offset: 1px;
    }
    .brutal-shadow-sm {
        box-shadow: 3px 3px 0px 0px #000;
    }
    .brutal-shadow-xs {
        box-shadow: 2px 2px 0px 0px #000;
    }
    .brutal-shadow {
        box-shadow: 6px 6px 0px 0px #000;
    }
    .brutal-border {
        border: 2px solid black;
    }
    .tool-btn:hover {
        transform: translateY(-1px);
        box-shadow: 1px 1px 0px 0px #000;
    }
    .color-btn:hover {
        transform: scale(1.1);
    }
</style>
@endsection
