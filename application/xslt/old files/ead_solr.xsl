<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0"  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" />

    <xsl:template match="/">
        <add>
            <doc><xsl:apply-templates/></doc></add>

    </xsl:template>

    <!--<xsl:template match="author">-->
    <!--<field name="author"> <xsl:value-of select="."/></field>-->

    <!--</xsl:template>-->
    <xsl:template match="titleproper">

        <field name="collection"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="date">
        <field name="date"> <xsl:value-of select="."/></field>
    </xsl:template>
    <xsl:template match="publisher">
        <field name="publisher"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="unitdate">

        <field name="unitdate"> <xsl:value-of select="."/></field>

    </xsl:template>

    <xsl:template match="profiledesc">
        <field name="profiledesc"> <xsl:value-of select="."/></field>
    </xsl:template>

    <xsl:template match="langusage">
        <field name="langusage"> <xsl:value-of select="."/></field>
    </xsl:template>

    <xsl:template match="recordid">
        <field name="link">
            <xsl:value-of select="@instanceurl"/>
        </field>

        <field name="recordId">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="address">
        <field name="address"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="ref">

    </xsl:template>
    <xsl:template match="languagedeclaration">

    </xsl:template>
    <xsl:template match="maintenancehistory">

    </xsl:template>
    <xsl:template match="agencycode">
        <field name="agencycode"> <xsl:value-of select="."/></field>

    </xsl:template>

    <xsl:template match="corpname">
        <field name="corpname"> <xsl:value-of select="part"/></field>

    </xsl:template>
    <xsl:template match="origination">
        <field name="origination"> <xsl:value-of select="persname"/></field>

    </xsl:template>
    <xsl:template match="unittitle">
        <field name="unittitle"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="unitid">
        <field name="id"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="unitdatestructured">

    </xsl:template>
    <xsl:template match="physdescset">

    </xsl:template>
    <xsl:template match="langmaterial">

    </xsl:template>

    <xsl:template match="agencyname">
        <field name="agencyname"> <xsl:value-of select="."/></field>
    </xsl:template>

    <!--xsl:template match="archdesc"-->
    <!--doc-->
    <xsl:template match="accessrestrict">
        <field name="accessrestrict">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="userestrict">
        <field name="userestrict">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="scopecontent">
        <field name="scopecontent">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="bioghist">
        <field name="bioghist">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="controlaccess">

        <field name="persname">
            <xsl:value-of select="persname"/>

        </field>
        <field name="subject">
            <xsl:value-of select="subject"/>

        </field>

    </xsl:template>
    <!--/doc-->
    <!--/xsl:template-->

    <xsl:template match="dsc">

        <xsl:for-each select="c01">
            <doc>
                <field name="c01">
                    <xsl:value-of select="@level"/>
                </field>
                 <field name="collection">
                     <xsl:value-of select="preceding::titleproper"/>
                </field>
                <field name="id">
                    <xsl:value-of select="did/unitid"/>
                </field>
                <field name="unittitle">
                    <xsl:value-of select="did/unittitle"/>

                </field>

                <field name="fromdate">
                    <xsl:value-of select="did/unitdatestructured/daterange/fromdate"/>

                </field>
                <field name="todate">
                    <xsl:value-of select="did/unitdatestructured/daterange/todate"/>
                </field>
                <xsl:for-each select="c02">
                    <doc>
                        <field name="collection">
                            <xsl:value-of select="preceding::titleproper"/>
                        </field>
                        <field name="c02"> <xsl:value-of select="@level"/></field>
                        <field name="unittitle">
                            <xsl:value-of select="did/unittitle"/>
                        </field>
                        <field name="unitdate">
                            <xsl:value-of select="did/unitdate"/>
                        </field>
                        <field name="id">
                            <xsl:value-of select="did/unitid"/>
                        </field>
                        <field name="container">
                            <xsl:value-of select="did/container"/>
                        </field>
                        <field name="unittitle">
                            <xsl:value-of select="did/unittitle"/>
                        </field>
                        <field name="scopecontent">
                            <xsl:value-of select="did/unittitle"/>

                        </field>
                    </doc>

                </xsl:for-each>
            </doc>

        </xsl:for-each>


    </xsl:template>
</xsl:stylesheet>