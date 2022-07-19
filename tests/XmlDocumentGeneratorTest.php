<?php declare(strict_types=1);

namespace Cspray\ArchitecturalDecision;

use Cspray\AnnotatedTarget\PhpParserAnnotatedTargetParser;
use Cspray\ArchitecturalDecision\Stub\Adr\StubDocBlockArchitecturalDecision;
use org\bovigo\vfs\vfsStream as VirtualFilesystem;
use org\bovigo\vfs\vfsStreamDirectory as VirtualDirectory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Cspray\ArchitecturalDecision\XmlDocumentGenerator
 */
final class XmlDocumentGeneratorTest extends TestCase {

    private VirtualDirectory $vfs;

    private XmlDocumentGenerator $subject;

    protected function setUp() : void {
        parent::setUp();
        $this->vfs = VirtualFilesystem::setup();

        $this->subject = new XmlDocumentGenerator(
            $gatherer = new ArchitecturalDecisionAttributeGatherer(new PhpParserAnnotatedTargetParser())
        );

        $gatherer->registerAttribute(StubDocBlockArchitecturalDecision::class);
    }

    public function testGenerateXmlDocument() : void {
        $expected = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<architecturalDecisions xmlns="https://architectural-decision.cspray.io/schema/architectural-decision.xsd">
  <architecturalDecision>
    <attribute>Cspray\ArchitecturalDecision\Stub\Adr\StubDocBlockArchitecturalDecision</attribute>
    <title>Stub Title</title>
    <date>2022-01-01</date>
    <status>Accepted</status>
    <contents><![CDATA[This is a DocBlock explaining an architectural decision.

This is the content that should be returned from DocBlockArchitecturalDecision::getContents. It will be what is
displayed in the CLI tool explaining the reason for the Architectural Decision.]]></contents>
    <codeAnnotations>
      <codeAnnotation>
        <classConstant>
          <class>Cspray\ArchitecturalDecision\Fixture\AllAttributeTargets\KitchenSink</class>
          <constant>MY_CONST</constant>
        </classConstant>
      </codeAnnotation>
      <codeAnnotation>
        <classProperty>
          <class>Cspray\ArchitecturalDecision\Fixture\AllAttributeTargets\KitchenSink</class>
          <property>someProp</property>
        </classProperty>
      </codeAnnotation>
      <codeAnnotation>
        <classMethod>
          <class>Cspray\ArchitecturalDecision\Fixture\AllAttributeTargets\KitchenSink</class>
          <method>myMethod</method>
        </classMethod>
      </codeAnnotation>
      <codeAnnotation>
        <classMethodParameter>
          <class>Cspray\ArchitecturalDecision\Fixture\AllAttributeTargets\KitchenSink</class>
          <method>myPrivateMethod</method>
          <parameter>param</parameter>
        </classMethodParameter>
      </codeAnnotation>
      <codeAnnotation>
        <class>Cspray\ArchitecturalDecision\Fixture\AllAttributeTargets\KitchenSink</class>
      </codeAnnotation>
      <codeAnnotation>
        <function>Cspray\ArchitecturalDecision\Fixture\AllAttributeTargets\myFunction</function>
      </codeAnnotation>
      <codeAnnotation>
        <functionParameter>
          <function>Cspray\ArchitecturalDecision\Fixture\AllAttributeTargets\anotherFunction</function>
          <parameter>flag</parameter>
        </functionParameter>
      </codeAnnotation>
    </codeAnnotations>
  </architecturalDecision>
</architecturalDecisions>

XML;

        $this->subject->generateDocument('vfs://root/architectural-decisions.xml', [__DIR__ . '/Fixture/AllAttributeTargets']);

        self::assertStringEqualsFile('vfs://root/architectural-decisions.xml', $expected);
    }

    public function testCodebaseWithOnlyRecordsAndNoAnnotations() : void {
        $expected = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<architecturalDecisions xmlns="https://architectural-decision.cspray.io/schema/architectural-decision.xsd">
  <architecturalDecision>
    <attribute>Cspray\ArchitecturalDecision\Stub\Adr\StubDocBlockArchitecturalDecision</attribute>
    <title>Stub Title</title>
    <date>2022-01-01</date>
    <status>Accepted</status>
    <contents><![CDATA[This is a DocBlock explaining an architectural decision.

This is the content that should be returned from DocBlockArchitecturalDecision::getContents. It will be what is
displayed in the CLI tool explaining the reason for the Architectural Decision.]]></contents>
  </architecturalDecision>
</architecturalDecisions>

XML;
        $this->subject->generateDocument('vfs://root/architectural-decisions.xml', [__DIR__ . '/Fixture/NoAttributes']);

        self::assertStringEqualsFile('vfs://root/architectural-decisions.xml', $expected);
    }
}