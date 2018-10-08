var codes = ["\x46\x50\x53", "\x47\x68\x6F\x73\x74", "\x78", "\x79", "\x72\x61\x6E\x64\x6F\x6D", "\x66\x6C\x6F\x6F\x72", "\x67\x65\x74\x54\x69\x63\x6B", "\x72\x6F\x75\x6E\x64", "\x23\x46\x46\x46\x46\x46\x46", "\x23\x30\x30\x30\x30\x42\x42", "\x23\x32\x32\x32", "\x62\x6C\x6F\x63\x6B\x53\x69\x7A\x65", "\x66\x69\x6C\x6C\x53\x74\x79\x6C\x65", "\x62\x65\x67\x69\x6E\x50\x61\x74\x68", "\x6D\x6F\x76\x65\x54\x6F", "\x71\x75\x61\x64\x72\x61\x74\x69\x63\x43\x75\x72\x76\x65\x54\x6F", "\x63\x6C\x6F\x73\x65\x50\x61\x74\x68", "\x66\x69\x6C\x6C", "\x23\x46\x46\x46", "\x61\x72\x63", "\x23\x30\x30\x30", "\x69\x73\x46\x6C\x6F\x6F\x72\x53\x70\x61\x63\x65", "\x69\x73\x57\x61\x6C\x6C\x53\x70\x61\x63\x65", "\x55\x73\x65\x72", "\x41\x52\x52\x4F\x57\x5F\x4C\x45\x46\x54", "\x41\x52\x52\x4F\x57\x5F\x55\x50", "\x41\x52\x52\x4F\x57\x5F\x52\x49\x47\x48\x54", "\x41\x52\x52\x4F\x57\x5F\x44\x4F\x57\x4E", "\x73\x65\x6E\x64\x50\x6F\x69\x6E\x74\x73", "\x73\x65\x74\x53\x74\x61\x74\x65", "\x6B\x65\x79\x43\x6F\x64\x65", "\x75\x6E\x64\x65\x66\x69\x6E\x65\x64", "\x70\x72\x65\x76\x65\x6E\x74\x44\x65\x66\x61\x75\x6C\x74", "\x73\x74\x6F\x70\x50\x72\x6F\x70\x61\x67\x61\x74\x69\x6F\x6E", "\x62\x6C\x6F\x63\x6B", "\x42\x49\x53\x43\x55\x49\x54", "\x50\x49\x4C\x4C", "\x73\x65\x74\x42\x6C\x6F\x63\x6B", "\x63\x6F\x6D\x70\x6C\x65\x74\x65\x64\x4C\x65\x76\x65\x6C", "\x65\x61\x74\x65\x6E\x50\x69\x6C\x6C", "\x23\x46\x46\x46\x46\x30\x30", "\x50\x49", "\x73\x74\x61\x72\x74", "\x65\x6E\x64", "\x64\x69\x72\x65\x63\x74\x69\x6F\x6E", "\x4D\x61\x70", "\x57\x41\x4C\x4C", "\x45\x4D\x50\x54\x59", "\x73\x74\x72\x6F\x6B\x65\x53\x74\x79\x6C\x65", "\x23\x30\x30\x30\x30\x46\x46", "\x6C\x69\x6E\x65\x57\x69\x64\x74\x68", "\x6C\x69\x6E\x65\x43\x61\x70", "\x6C\x65\x6E\x67\x74\x68", "\x57\x41\x4C\x4C\x53", "\x6D\x6F\x76\x65", "\x6C\x69\x6E\x65", "\x6C\x69\x6E\x65\x54\x6F", "\x63\x75\x72\x76\x65", "\x73\x74\x72\x6F\x6B\x65", "\x73\x74\x72\x69\x6E\x67\x69\x66\x79", "\x70\x61\x72\x73\x65", "\x66\x69\x6C\x6C\x52\x65\x63\x74", "\x61\x62\x73", "\x42\x4C\x4F\x43\x4B", "\x41\x75\x64\x69\x6F", "\x61\x75\x64\x69\x6F", "\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74", "\x63\x61\x6E\x70\x6C\x61\x79\x74\x68\x72\x6F\x75\x67\x68", "\x61\x64\x64\x45\x76\x65\x6E\x74\x4C\x69\x73\x74\x65\x6E\x65\x72", "\x70\x72\x65\x6C\x6F\x61\x64", "\x74\x72\x75\x65", "\x73\x65\x74\x41\x74\x74\x72\x69\x62\x75\x74\x65", "\x61\x75\x74\x6F\x62\x75\x66\x66\x65\x72", "\x73\x72\x63", "\x70\x61\x75\x73\x65", "\x6C\x6F\x61\x64\x65\x64", "\x74\x6F\x74\x61\x6C", "\x66\x75\x6E\x63\x74\x69\x6F\x6E", "\x72\x65\x6D\x6F\x76\x65\x45\x76\x65\x6E\x74\x4C\x69\x73\x74\x65\x6E\x65\x72", "\x63\x75\x72\x72\x65\x6E\x74\x54\x69\x6D\x65", "\x65\x6E\x64\x65\x64", "\x70\x75\x73\x68", "\x73\x6F\x75\x6E\x64\x44\x69\x73\x61\x62\x6C\x65\x64", "\x70\x6C\x61\x79", "\x23\x30\x30\x46\x46\x44\x45", "\x23\x46\x46\x30\x30\x30\x30", "\x23\x46\x46\x42\x38\x44\x45", "\x23\x46\x46\x42\x38\x34\x37", "\x66\x6F\x6E\x74", "\x31\x32\x70\x78\x20\x42\x44\x43\x61\x72\x74\x6F\x6F\x6E\x53\x68\x6F\x75\x74\x52\x65\x67\x75\x6C\x61\x72", "\x6E\x65\x77", "\x66\x69\x6C\x6C\x54\x65\x78\x74", "\x31\x34\x70\x78\x20\x42\x44\x43\x61\x72\x74\x6F\x6F\x6E\x53\x68\x6F\x75\x74\x52\x65\x67\x75\x6C\x61\x72", "\x77\x69\x64\x74\x68", "\x6D\x65\x61\x73\x75\x72\x65\x54\x65\x78\x74", "\x68\x65\x69\x67\x68\x74", "\x72\x65\x73\x65\x74\x50\x6F\x73\x69\x74\x69\x6F\x6E", "\x72\x65\x73\x65\x74", "\x64\x72\x61\x77", "\x4E", "\x53", "\x64\x69\x73\x61\x62\x6C\x65\x53\x6F\x75\x6E\x64", "\x50", "\x72\x65\x73\x75\x6D\x65", "\x50\x61\x75\x73\x65\x64", "\x6B\x65\x79\x44\x6F\x77\x6E", "\x6C\x6F\x73\x65\x4C\x69\x66\x65", "\x67\x65\x74\x4C\x69\x76\x65\x73", "\x74\x68\x65\x53\x63\x6F\x72\x65", "\x63\x6F\x6E\x74\x65\x6E\x74", "\x61\x74\x74\x72", "\x6D\x65\x74\x61\x5B\x6E\x61\x6D\x65\x3D\x22\x63\x73\x72\x66\x2D\x74\x6F\x6B\x65\x6E\x22\x5D", "\x61\x6A\x61\x78\x53\x65\x74\x75\x70", "\x2F\x73\x65\x74\x70\x6F\x69\x6E\x74\x73", "\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E\x2E", "\x70\x6F\x73\x74", "\x70\x6F\x77", "\x73\x71\x72\x74", "\x23\x30\x30\x30\x30\x30\x30", "\x23\x30\x30\x46\x46\x30\x30", "\x62\x6F\x6C\x64\x20\x31\x36\x70\x78\x20\x73\x61\x6E\x73\x2D\x73\x65\x72\x69\x66", "\x73", "\x53\x63\x6F\x72\x65\x3A\x20", "\x4C\x65\x76\x65\x6C\x3A\x20", "\x64\x72\x61\x77\x42\x6C\x6F\x63\x6B", "\x63\x65\x69\x6C", "\x6F\x6C\x64", "\x69\x73\x56\x75\x6E\x65\x72\x61\x62\x6C\x65", "\x65\x61\x74\x67\x68\x6F\x73\x74", "\x65\x61\x74", "\x61\x64\x64\x53\x63\x6F\x72\x65", "\x69\x73\x44\x61\x6E\x67\x65\x72\x6F\x75\x73", "\x64\x69\x65", "\x64\x72\x61\x77\x50\x69\x6C\x6C\x73", "\x50\x72\x65\x73\x73\x20\x4E\x20\x74\x6F\x20\x73\x74\x61\x72\x74\x20\x61\x20\x4E\x65\x77\x20\x67\x61\x6D\x65", "\x64\x72\x61\x77\x44\x65\x61\x64", "\x53\x74\x61\x72\x74\x69\x6E\x67\x20\x69\x6E\x3A\x20", "\x65\x61\x74\x70\x69\x6C\x6C", "\x6D\x61\x6B\x65\x45\x61\x74\x61\x62\x6C\x65", "\x6E\x65\x77\x4C\x65\x76\x65\x6C", "\x6F\x66\x66\x73\x65\x74\x57\x69\x64\x74\x68", "\x63\x61\x6E\x76\x61\x73", "\x70\x78", "\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64", "\x32\x64", "\x67\x65\x74\x43\x6F\x6E\x74\x65\x78\x74", "\x4C\x6F\x61\x64\x69\x6E\x67\x20\x2E\x2E\x2E", "\x6F\x67\x67", "\x6D\x70\x33", "\x61\x75\x64\x69\x6F\x2F\x6F\x70\x65\x6E\x69\x6E\x67\x5F\x73\x6F\x6E\x67\x2E", "\x61\x75\x64\x69\x6F\x2F\x64\x69\x65\x2E", "\x61\x75\x64\x69\x6F\x2F\x65\x61\x74\x67\x68\x6F\x73\x74\x2E", "\x61\x75\x64\x69\x6F\x2F\x65\x61\x74\x70\x69\x6C\x6C\x2E", "\x65\x61\x74\x69\x6E\x67", "\x61\x75\x64\x69\x6F\x2F\x65\x61\x74\x69\x6E\x67\x2E\x73\x68\x6F\x72\x74\x2E", "\x65\x61\x74\x69\x6E\x67\x32", "\x70\x6F\x70", "\x6C\x6F\x61\x64", "\x50\x72\x65\x73\x73\x20\x4E\x20\x74\x6F\x20\x53\x74\x61\x72\x74", "\x6B\x65\x79\x64\x6F\x77\x6E", "\x6B\x65\x79\x70\x72\x65\x73\x73", "\x73\x65\x74\x49\x6E\x74\x65\x72\x76\x61\x6C", "", "\x66\x72\x6F\x6D\x43\x68\x61\x72\x43\x6F\x64\x65", "\x4E\x55\x4D\x5F\x50\x41\x44\x5F", "\x46", "\x4D\x41\x50", "\x68\x74\x6D\x6C", "\x2E\x73\x68\x61\x74\x6F\x73\x68\x69\x2D\x61\x6D\x6F\x75\x6E\x74", "\x73\x74\x61\x74\x69\x63", "\x6D\x6F\x64\x61\x6C", "\x23\x67\x65\x74\x52\x65\x77\x61\x72\x64\x42\x6F\x78", "\x23\x6C\x69\x6D\x69\x74\x52\x65\x61\x63\x68\x42\x6F\x78"];

function show(){
    for(i=0; i< codes.length ; ++i){
        console.log(i + " " + codes[i]);
        console.log(i + " " + JSON.stringify(codes[i]));    
    }
}

show();