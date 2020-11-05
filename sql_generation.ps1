Clear-Host
$files = Get-ChildItem -path "public\video_sym" -Recurse 
Foreach($fi in $files){
    Write-Output $fi.Name 
}
Read-Host -Prompt "Press Enter to Exit..."