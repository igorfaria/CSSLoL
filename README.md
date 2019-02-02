# CSSLoL

An standalone CSS optimizer in PHP.

# Optimize
  - Remove zeros when not needed
  - rgb to hex
  - abbreviation for hex (#ffcc00 -> #fc0) 
  - add prefixes (-webkit-, -moz-, -ms- and -o-)
- Support to media queries
- Support to animations

# Minify
Yeah it does. Remove whitespaces, tabs, comments and those things.

# Configs
-	Variables  - replace variables to values
-	Overwrite - verify if already have that property defined to that same selector and replace it, to be used in some specifics cases like the one that make me do this  :D 
- Auto Prefixer - add prefixes automatically if not yet defined to specified properties that you define 



# Public Methods
- Append - To add some css in text
-	Load (local and remote) - To load some css file local or remote
- Get (array and text) - to get the array of parsed css to change the data structury 
-	Save - Save the final css to some final file (minified or beautified)
- Set (array and text) - to set the array of parsed css or in text, it will not append, it will replace the actual data
