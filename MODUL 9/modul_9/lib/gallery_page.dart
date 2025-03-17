// gallery_page.dart
import 'dart:io';
import 'package:flutter/material.dart';
import 'package:path_provider/path_provider.dart';

class GalleryPage extends StatefulWidget {
  const GalleryPage({Key? key}) : super(key: key);

  @override
  _GalleryPageState createState() => _GalleryPageState();
}

class _GalleryPageState extends State<GalleryPage> {
  List<File> _imageFiles = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadImages();
  }

  Future<void> _loadImages() async {
    setState(() {
      _isLoading = true;
    });

    try {
      final directory = await getApplicationDocumentsDirectory();
      final files = directory.listSync();

      // Filter for image files
      _imageFiles =
          files.whereType<File>().where((file) {
            final lowerPath = file.path.toLowerCase();
            return lowerPath.endsWith('.jpg') ||
                lowerPath.endsWith('.jpeg') ||
                lowerPath.endsWith('.png');
          }).toList();

      // Sort by most recent first
      _imageFiles.sort(
        (a, b) => b.lastModifiedSync().compareTo(a.lastModifiedSync()),
      );
    } catch (e) {
      print('Error loading images: $e');
    }

    setState(() {
      _isLoading = false;
    });
  }

  Future<void> _deleteImage(File imageFile) async {
    try {
      await imageFile.delete();
      setState(() {
        _imageFiles.remove(imageFile);
      });

      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Photo deleted'),
          duration: Duration(seconds: 2),
        ),
      );
    } catch (e) {
      print('Error deleting image: $e');
    }
  }

  void _showImageDetail(File imageFile) {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (context) => _ImageDetailPage(imageFile: imageFile),
      ),
    ).then((_) => _loadImages());
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Gallery'),
        actions: [
          IconButton(icon: const Icon(Icons.refresh), onPressed: _loadImages),
        ],
      ),
      body:
          _isLoading
              ? const Center(child: CircularProgressIndicator())
              : _imageFiles.isEmpty
              ? const Center(child: Text('No photos yet'))
              : GridView.builder(
                padding: const EdgeInsets.all(8),
                gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisCount: 3,
                  crossAxisSpacing: 8,
                  mainAxisSpacing: 8,
                ),
                itemCount: _imageFiles.length,
                itemBuilder: (context, index) {
                  return GestureDetector(
                    onTap: () => _showImageDetail(_imageFiles[index]),
                    child: Hero(
                      tag: _imageFiles[index].path,
                      child: Container(
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(8),
                          image: DecorationImage(
                            image: FileImage(_imageFiles[index]),
                            fit: BoxFit.cover,
                          ),
                        ),
                      ),
                    ),
                  );
                },
              ),
    );
  }
}

class _ImageDetailPage extends StatelessWidget {
  final File imageFile;

  const _ImageDetailPage({Key? key, required this.imageFile}) : super(key: key);

  Future<void> _deleteImage(BuildContext context) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder:
          (context) => AlertDialog(
            title: const Text('Delete Image'),
            content: const Text('Are you sure you want to delete this image?'),
            actions: [
              TextButton(
                child: const Text('Cancel'),
                onPressed: () => Navigator.pop(context, false),
              ),
              TextButton(
                child: const Text('Delete'),
                onPressed: () => Navigator.pop(context, true),
              ),
            ],
          ),
    );

    if (confirm == true) {
      try {
        await imageFile.delete();
        if (context.mounted) {
          Navigator.pop(context);
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              content: Text('Photo deleted'),
              duration: Duration(seconds: 2),
            ),
          );
        }
      } catch (e) {
        print('Error deleting image: $e');
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      appBar: AppBar(
        backgroundColor: Colors.black,
        actions: [
          IconButton(
            icon: const Icon(Icons.delete),
            onPressed: () => _deleteImage(context),
          ),
          IconButton(
            icon: const Icon(Icons.share),
            onPressed: () {
              // Share functionality would be implemented here
              ScaffoldMessenger.of(context).showSnackBar(
                const SnackBar(
                  content: Text('Sharing not implemented'),
                  duration: Duration(seconds: 2),
                ),
              );
            },
          ),
        ],
      ),
      body: Center(
        child: Hero(
          tag: imageFile.path,
          child: Image.file(imageFile, fit: BoxFit.contain),
        ),
      ),
    );
  }
}
